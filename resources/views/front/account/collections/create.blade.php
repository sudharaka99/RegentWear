@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Add Product</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.slidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')

                <form action="" method="POST" enctype="multipart/form-data" id="createCollectionForm" name="createCollectionForm">
                    @csrf
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-4">Product Details</h3>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Title<span class="req">*</span></label>
                                    <input type="text" name="title" class="form-control" placeholder="Slim Fit T-Shirt">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Price<span class="req">*</span></label>
                                    <input type="text" name="price" class="form-control" placeholder="e.g. 4990.00">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Category<span class="req">*</span></label>
                                    <select name="category_id" class="form-control">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Brand<span class="req">*</span></label>
                                    <select name="brand_id" class="form-control">
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Size<span class="req">*</span></label>
                                    <select name="size" class="form-control">
                                        <option value="">Select Size</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                        <option value="XXL">XXL</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Color<span class="req">*</span></label>
                                    <select name="color" class="form-control">
                                        <option value="">Select Color</option>
                                        <option value="Yellow">Yellow</option>
                                        <option value="Red">Red</option>
                                        <option value="Black">Black</option>
                                        <option value="Luminex">Luminex</option>
                                        <option value="Cream">Cream</option>
                                        <option value="Dark Blue">Dark Blue</option>
                                        <option value="Green">Green</option>
                                        <option value="ASH">ASH</option>
                                        <option value="MAROON">MAROON</option>
                                        <option value="BLUE">BLUE</option>
                                        <option value="PINK">PINK</option>
                                        <option value="BEIGE">BEIGE</option>
                                        <option value="LIGHT BROWN">LIGHT BROWN</option>
                                        <option value="WHITE">WHITE</option>
                                        <option value="BROWN">BROWN</option>
                                        <option value="BROWNISH RED">BROWNISH RED</option>
                                        <option value="OTHER">OTHER</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Material</label>
                                    <input type="text" name="material" class="form-control" placeholder="Cotton, Denim">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Stock<span class="req">*</span></label>
                                    <input type="number" name="stock" class="form-control" min="0" placeholder="e.g. 100">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Fit</label>
                                    <input type="text" name="fit" class="form-control" placeholder="Slim, Regular">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Style</label>
                                    <input type="text" name="style" class="form-control" placeholder="Casual, Formal">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="mb-2">Description<span class="req">*</span></label>
                                <textarea name="description" class="textarea form-control" rows="4" placeholder="Detailed product description"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="mb-2">Highlights</label>
                                <textarea name="highlights" class="textarea form-control" rows="3" placeholder="Key product features"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="mb-2">Main Image<span class="req">*</span></label>
                                <input type="file" name="main_image" class="form-control">
                            </div>

                            <div class="mb-4">
                                <label class="mb-2">Additional Images</label>
                                <input type="file" name="images[]" class="form-control" multiple>
                                <small class="text-muted">You can upload multiple images</small>
                            </div>

                            <div class="mb-4 form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="is_featured" id="is_featured">
                                <label class="form-check-label" for="is_featured">Mark as Featured</label>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" value="1" name="status" id="status" checked>
                                <label class="form-check-label" for="status">Publish</label>
                            </div>
                        </div>

                        <div class="card-footer p-4 text-end">
                            <button type="submit" class="btn btn-primary">Save Product</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
@endsection

@section('customJS')
<script type="text/javascript">
$("#createCollectionForm").submit(function(e){
    e.preventDefault();
    $("button[type='submit']").prop('disabled',true);

    var formData = new FormData(this);

    $.ajax({
        url: '',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            $("button[type='submit']").prop('disabled',false);
            if(response.status === true) {
                window.location.href = "";
            } else {
                alert('Please check the form for errors.');
            }
        },
        error: function(response) {
            console.log("Error occurred");
            console.log(response);
            $("button[type='submit']").prop('disabled',false);
        }
    });
});
</script>
@endsection
