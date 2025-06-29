<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Collection;
use App\Models\Category;
use App\Models\Brand;




use Illuminate\Support\Facades\Auth;


class AccountController extends Controller
{
public function registration()
{
    return view('front.account.registration');
}

 public function processRegistration(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required|min:5',
        ]);
    
        if ($validator->passes()) {
            
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
    
            
            session()->flash('success', 'You have registered successfully.');
    
           
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
    
        } else {
          
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function authenticate(Request $request) {
        // Validate the email and password fields
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if ($validator->passes()) {
            // Attempt to log in the user with the provided email and password
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Fetch the authenticated user
                $user = Auth::user();
    
                // Debug log to ensure the user and role are correctly fetched
                \Log::info('User authenticated:', ['email' => $user->email, 'role' => $user->role]);
    
                // Check the role of the authenticated user
                if ($user->role === 'admin') {
                    // Redirect to the admin dashboard for admin users
                    return redirect()->route('');
                } elseif ($user->role === 'staff') {
                    // Redirect to the employer dashboard for employers
                    return redirect()->route('');
                
                } else {
                    // Redirect to the user profile for general users (customers)
                    return redirect()->route('account.profile');
                }
            } else {
                // Debug log for failed login attempt
                \Log::error('Login failed for user:', ['email' => $request->email]);
    
                // If authentication fails, redirect back to the login page with an error message
                return redirect()->route('account.login')->with('error', 'Either Email/Password is incorrect');
            }
        } else {
            // If validation fails, redirect back to the login page with validation errors
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

public function login()
{
    return view('front.account.login');
}

public function logout(Request $request)
{
    Auth::logout();
    return redirect()->route('home')->with('success', 'You have logged out successfully.');

}

public function profile()
{
    $user = Auth::user();
    return view('front.account.profile', compact('user'));

}

public function updateProfile(Request $request) {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,' .$id. ',id'
        ]);

        if ($validator->passes()) {  // Corrected the spacing issue
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->country = $request->country;
            $user->zip = $request->zip;
            $user->save();

            session()->flash('success', 'Profile updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

     public function updateProfilePic(Request $request) {

        $id = Auth::user()->id; 

        $validator = Validator::make($request->all(),[
            'image' => 'required|image'
        ]);

        if($validator->passes()){

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = $id.'-'.time().'.'.$ext;
            $image->move(public_path('/profile_pic'), $imageName);

            // create a small thumbnail
            $sourcePath = public_path('/profile_pic/'.$imageName);
            $manager = new ImageManager(Driver::class);
            $img = $manager->read($sourcePath);

            // crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            $img->cover(150, 150);
            $img->toPng()->save(public_path('/profile_pic/thumb/'.$imageName));

            // Get current user from DB to get the latest image value
            $user = User::find($id);
            $oldImage = $user->image;

            // Update user image in DB
            $user->image = $imageName;
            $user->save();

            // Delete Old profile Pic if exists
            if ($oldImage && file_exists(public_path('/profile_pic/thumb/'.$oldImage))) {
                File::delete(public_path('/profile_pic/thumb/'.$oldImage));
            }
            if ($oldImage && file_exists(public_path('/profile_pic/'.$oldImage))) {
                File::delete(public_path('/profile_pic/'.$oldImage));
            }

            session()->flash('success','Profile Picture Updated successfully.');

            return response()->json([
                'status'=> true,
                'errors' => []
            ]);

        } else {
            return response()->json([
                'status'=> false,
                'errors' => $validator->errors()
            ]);
        }
    }


public function updatePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        if (Hash::check($request->old_password, Auth::user()->password) == false){
            session()->flash('error','Your old password is incorrect.');
            return response()->json([
                'status' => true                
            ]);
        }


        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->new_password);  
        $user->save();

        session()->flash('success','Password updated successfully.');
        return response()->json([
            'status' => true                
        ]);

    }

    public function forgotPassword(){
        return view('front.account.forgot-password');
    }

    public function processForgotPassword(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.forgotPassword')->withInput()->withErrors($validator);
        }

        $token = Str::random(60);

        \DB::table('password_resets')->where('email',$request->email)->delete();

        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Send Email here
        $user = User::where('email',$request->email)->first();
        $mailData =  [
            'token' => $token,
            'user' => $user,
            'subject' => 'You have requested to change your password.'
        ];

        Mail::to($request->email)->send(new ResetPasswordEmail($mailData));

        return redirect()->route('account.forgotPassword')->with('success','Reset password email has been sent to your inbox.');
        
    }

    public function resetPassword($tokenString) {
        $token = \DB::table('password_resets')->where('token',$tokenString)->first();

        if ($token == null) {
            return redirect()->route('account.forgotPassword')->with('error','Invalid token.');
        }

        return view('front.account.reset-password',[
            'tokenString' => $tokenString
        ]);
    }

    public function processResetPassword(Request $request) {

        $token = \DB::table('password_resets')->where('token',$request->token)->first();

        if ($token == null) {
            return redirect()->route('account.forgotPassword')->with('error','Invalid token.');
        }
        
        $validator = Validator::make($request->all(),[
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.resetPassword',$request->token)->withErrors($validator);
        }

        User::where('email',$token->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('account.login')->with('success','You have successfully changed your password.');

    }

    public function createcollections()
        {

            $categories = category::orderBy('name','ASC')->where('status',1)->get();
            $brands = brand::orderBy('name','ASC')->where('status',1)->get();

            return view('front.account.collections.create', [
                'categories' =>  $categories,
                'brands' => $brands, ]);
        }




public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'size' => 'required|string',
            'color' => 'required|string',
            'material' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'fit' => 'nullable|string',
            'style' => 'nullable|string',
            'description' => 'required|string',
            'highlights' => 'nullable|string',
            'main_image' => 'required|image|mimes:jpeg,png,jpg',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg',
            'is_featured' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ]);

        // Store main image
        $mainImagePath = $request->file('main_image')->store('collections', 'public');
        $validated['main_image'] = $mainImagePath;
        $validated['is_featured'] = $request->has('is_featured');
        $validated['status'] = $request->has('status');

        // Save product
        $collection = Collection::create($validated);

        // Store additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $imagePath = $imageFile->store('collections', 'public');
                CollectionImage::create([
                    'collection_id' => $collection->id,
                    'image' => $imagePath,
                ]);
            }
        }

        return response()->json([
        'status' => true,
        'message' => 'Product saved successfully.',
    ]);
    }

    public function myCollections()
    {
        // return view('front.account.collections.my-collections', [
        //     // 'collections' => Collection::where('user_id', Auth::id())->get(),  
        // ]);

      

            $collections = Collection::latest()->paginate(10);
            return view('front.account.collections.my-collections', [
                'collections' => $collections
            ]);
    }
}


