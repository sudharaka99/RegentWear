<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');




Route::group (['account'], function () {

    Route::group (['middleware' => 'guest'], function () {
        Route::get('/account/register', [AccountController::class, 'registration'])->name('account.registration');
        Route::post('/account/process-register', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
        Route::get('/account/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/account/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });

    Route::group (['middleware' => 'auth'], function () {
        Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');  
        Route::put('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::post('/account/updatep-rofile-picture', [AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');
        Route::get('/create-collections', [AccountController::class, 'createcollections'])->name('account.createcollections');
        Route::post('/collections/store', [AccountController::class, 'store'])->name('collections.store');
});
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
