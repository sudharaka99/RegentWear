@extends('admin.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
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

                <form method="POST" enctype="multipart/form-data" id="editProductForm">
                    @csrf
                    @method('PUT')

                    <div class="card border-0 shadow mb-4">
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-4">Edit Collection</h3>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label>Title<span class="req">*</span></label>
                                    <input type="text" name="title" class="form-control" value="{{ $collection->title }}">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label>Price<span class="req">*</span></label>
                                    <input type="text" name="price" class="form-control" value="{{ $collection->price }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label>Category<span class="req">*</span></label>
                                    <select name="category_id" class="form-control">
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $collection->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label>Brand<span class="req">*</span></label>
                                    <select name="brand_id" class="form-control">
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ $collection->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label>Size<span class="req">*</span></label>
                                    <select name="size" class="form-control">
                                        @foreach(['S','M','L','XL','XXL'] as $size)
                                            <option value="{{ $size }}" {{ $collection->size == $size ? 'selected' : '' }}>{{ $size }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label>Color<span class="req">*</span></label>
                                    <select name="color" class="form-control">
                                        @foreach(['Black','White','Red','Blue','Green','Yellow','Brown','Other'] as $color)
                                            <option value="{{ $color }}" {{ $collection->color == $color ? 'selected' : '' }}>{{ $color }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label>Stock<span class="req">*</span></label>
                                    <input type="number" name="stock" class="form-control" value="{{ $collection->stock }}">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label>Material</label>
                                    <select name="material" class="form-control">
                                        @foreach(['Cotton','Denim','Linen','Polyester','Other'] as $material)
                                            <option value="{{ $material }}" {{ $collection->material == $material ? 'selected' : '' }}>{{ $material }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label>Description<span class="req">*</span></label>
                                <textarea name="description" class="form-control" rows="4">{{ $collection->description }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label>Highlights</label>
                                <textarea name="highlights" class="form-control" rows="3">{{ $collection->highlights }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label>Main Image</label>
                                <input type="file" name="main_image" class="form-control">
                                @if($collection->main_image)
                                    <img src="{{ asset('storage/' . $collection->main_image) }}" class="img-thumbnail mt-2" style="width: 80px; height: 80px; object-fit: cover;">
                                @endif
                            </div>

                            <div class="mb-4">
                                <label>Additional Images</label>
                                <input type="file" name="images[]" class="form-control" multiple>
                                @if($collection->images && $collection->images->count())
                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                        @foreach($collection->images as $img)
                                            <div class="border p-1" style="width: 80px; height: 80px; overflow: hidden; border-radius: 5px;">
                                                <img src="{{ asset('storage/' . $img->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" name="is_featured" {{ $collection->is_featured ? 'checked' : '' }}>
                                <label class="form-check-label">Mark as Featured</label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" name="status" {{ $collection->status ? 'checked' : '' }}>
                                <label class="form-check-label">Publish</label>
                            </div>
                        </div>

                        <div class="card-footer p-4 text-end">
                            <button type="submit" class="btn btn-primary">Update Product</button>
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
    $("#editProductForm").submit(function(e) {
        e.preventDefault();
        $("button[type='submit']").prop('disabled', true);
        var formData = new FormData(this);

        $.ajax({
            url: '',
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
                alert("Unexpected error occurred");
                console.log(xhr);
            }
        });
    });
</script>
@endsection
