@extends('layouts.admin')
@section('content')
<div class="row">
    @can('show_category')
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Category List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($categories as $index=>$category)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $category->category_name}}</td>
                        <td>
                            <img width="100" src="{{ asset('uploads/category') }}/{{ $category->category_image }}" alt="">
                        </td>
                        <td>
                            @can('del_category')
                            <a data-link="{{ route('category.delete', $category->id) }}" class="btn btn-danger del">Delete</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="mt-3 card">
            <div class="card-header">
                <h3>Trash List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($trashes as $index=>$trash)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $trash->category_name}}</td>
                        <td>
                            <img width="100" src="{{ asset('uploads/category') }}/{{ $trash->category_image }}" alt="">
                        </td>
                        <td>
                            <a href="{{ route('restore', $trash->id) }}" class="btn btn-success">Restore</a>
                            <a data-link="{{ route('permanent.delete', $trash->id) }}" class="btn btn-danger del">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endcan
    
    @can('add_category')
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Category</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('store.category') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control">
                        @error('category_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Category Image</label>
                        <input type="file" name="category_image" class="form-control">
                        @error('category_image')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection

@section('footer_script')

<script>
    $('.del').click(function(){
        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
            let link = $(this).attr('data-link')
            window.location.href = link
        }
        });
    })
</script>

@if (session('success'))
    <script>
        const Toast = Swal.mixin({
        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
        icon: "success",
        title: '{{ session('success') }}'
        });
    </script>
@endif

@if (session('del'))
    <script>
        Swal.fire({
            title: "Deleted!",
            text: '{{ session('del') }}',
            icon: "success"
        });
    </script>
@endif
@endsection