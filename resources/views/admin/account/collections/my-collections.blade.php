@extends('admin.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">My Collections</li>
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

                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fs-4 mb-0">My Collections</h3>
                            <a href="{{ route('admin.createcollections') }}" class="btn btn-primary">Add Collection</a>
                        </div>

                        <div class="table-responsive mt-3">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Created On</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($collections as $collection)
                                        <tr>
                                            <td>
                                                <div class="fw-bold">{{ $collection->title }}</div>
                                                <div class="text-muted">{{ $collection->category->name }} • {{ $collection->brand->name }}</div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($collection->created_at)->format('d M, Y') }}</td>
                                            <td>{{ $collection->stock }} in stock</td>
                                            <td>
                                                <span class="badge bg-{{ $collection->status ? 'success' : 'danger' }}">
                                                    {{ $collection->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown text-end">
                                                    <button class="btn" data-bs-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href=""><i class="fa fa-eye"></i> View</a></li>
                                                        <li><a class="dropdown-item" href="{{ Route('admin.editCollections',$collection->id) }}"><i class="fa fa-edit"></i> Edit</a></li>
                                                        <li><a class="dropdown-item text-danger" href="#" onclick="deleteCollection({{ $collection->id }})"><i class="fa fa-trash"></i> Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No collections found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{$collections->links()}}
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJS')
<script>
    function deleteCollection(collectionId) {
        if (confirm("Are you sure you want to delete this collection?")) {
            $.ajax({
                url: '',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    collectionId: collectionId
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert("Failed to delete collection.");
                }
            });
        }
    }
</script>
@endsection
