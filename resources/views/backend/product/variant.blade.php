@extends('layouts.admin')
@section('content')
<div class="row">
    @can('add_variant')
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Color List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Color Name</th>
                        <th>Color</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($colors as $color)                        
                    <tr>
                        <td>{{ $color->color_name }}</td>
                        
                        <td><i class="d-block"  style="width: 30px; height:30px; background:{{ $color->color_code }}"></i></td>
                        <td><a href="" class="btn btn-danger">Delete</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="mt-3 card">
            <div class="card-header">
                <h3>Size List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Size Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($sizes as $size)                        
                    <tr>
                        <td>{{ $size->size_name }}</td>
                        
                        <td><a href="" class="btn btn-danger">Delete</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Color</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('add.color') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Color Name</label>
                        <input type="text" class="form-control" name="color_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Color Code</label>
                        <input type="text" class="form-control" name="color_code">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add color</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-3 card">
            <div class="card-header">
                <h3>Add Size</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('add.size') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Size Name</label>
                        <input type="text" class="form-control" name="size_name">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add size</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <div>
        <h3>You dont have permission to see this page</h3>
    </div>
    @endcan
</div>
@endsection