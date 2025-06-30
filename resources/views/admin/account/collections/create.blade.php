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
                @include('admin.account.slidebar')
            </div>

            <div class="col-lg-9">
                @include('front.message')

                <form method="POST" enctype="multipart/form-data" id="createProductForm">
                    @csrf
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-4">Add to collections</h3>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label>Title<span class="req">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="e.g. Slim Fit T-Shirt">
                                    <p></p>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label>Price<span class="req">*</span></label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="e.g. 4990.00">
                                    <p></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label>Category<span class="req">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label>Brand<span class="req">*</span></label>
                                    <select name="brand_id" id="brand_id" class="form-control">
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label>Size<span class="req">*</span></label>
                                    <select name="size" id="size" class="form-control">
                                        <option value="">Select Size</option>
                                        <option>S</option><option>M</option><option>L</option><option>XL</option><option>XXL</option>
                                    </select>
                                    <p></p>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label>Color<span class="req">*</span></label>
                                    <select name="color" id="color" class="form-control">
                                        <option value="">Select Color</option>
                                        <option>Black</option><option>White</option><option>Red</option><option>Blue</option><option>Green</option>
                                        <option>Yellow</option><option>Brown</option><option>Other</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label>Stock<span class="req">*</span></label>
                                    <input type="number" name="stock" id="stock" class="form-control" placeholder="e.g. 50">
                                    <p></p>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label>Material</label>
                                    <select name="material" id="material" class="form-control">
                                        <option value="">Select Material</option>
                                        <option>Cotton</option><option>Denim</option><option>Linen</option><option>Polyester</option><option>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label>Description<span class="req">*</span></label>
                                <textarea name="description" id="description" class="form-control textarea" rows="4" placeholder="Product details..."></textarea>
                                <p></p>
                            </div>

                            <div class="mb-4">
                                <label>Highlights</label>
                                <textarea name="highlights" class="form-control textarea" rows="3" placeholder="e.g. Lightweight, breathable"></textarea>
                            </div>

                            <div class="mb-4">
                                <label>Main Image<span class="req">*</span></label>
                                <input type="file" name="main_image" id="main_image" class="form-control">
                                <p></p>
                            </div>

                            <div class="mb-4">
                                <label>Additional Images</label>
                                <input type="file" name="images[]" class="form-control" multiple>
                                <small class="text-muted">You can upload multiple product images</small>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" name="is_featured" id="is_featured">
                                <label class="form-check-label" for="is_featured">Mark as Featured</label>
                            </div>

                            <div class="form-check mb-3">
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
<script>
    $("#createProductForm").submit(function(e) {
        e.preventDefault();
        $("button[type='submit']").prop('disabled', true);
        var formData = new FormData(this);

        $.ajax({
            url: '{{ route("admin.collectionsStore") }}',
            type: 'POST',
            dataType: 'json',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $("button[type='submit']").prop('disabled', false);
                if (response.status === true) {
                    window.location.href = "{{ route('admin.myCollections') }}";
                } else {
                    $(".is-invalid").removeClass('is-invalid');
                    $("p.invalid-feedback").removeClass('invalid-feedback').html('');
                    $.each(response.errors, function(key, value) {
                        $('#' + key).addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(value[0]);
                    });
                }
            },
            error: function(xhr) {
                $("button[type='submit']").prop('disabled', false);
                $(".is-invalid").removeClass('is-invalid');
                $("p.invalid-feedback").removeClass('invalid-feedback').html('');
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('#' + key).addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(value[0]);
                    });
                } else {
                    alert("Unexpected error occurred");
                    console.log(xhr);
                }
            }
        });
    });
</script>
@endsection
