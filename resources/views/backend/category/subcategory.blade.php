@extends('layouts.admin')
@section('content')
<div class="row">
    @can('show_subcategory')
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Subcategory List</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($categories as $category)
                    <div class="my-3 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>{{ $category->category_name }}</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Subcategory</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($category->rel_to_subcategory as $sub)
                                        <tr>
                                            <td>{{ $sub->subcategory_name }}</td>
                                            <td><a href="{{ route('del.subcategory', $sub->id) }}" class="btn btn-danger">Delete</a></td>
                                        </tr>
                                    @endforeach
                                    
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
    @endcan
    @can('add_subcategory')
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Sub Category</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('store.subcategory') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)                                
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subcategory Name</label>
                        <input type="text" class="form-control" name="subcategory_name">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Subcategory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection