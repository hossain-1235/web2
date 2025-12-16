@extends('layouts.admin')
@section('content')
<div class="row">
    @can('show_tag')
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Tag List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Tag</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($tags as $index=>$tag)                        
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $tag->tag_name }}</td>
                        <td>
                            <a href="{{ route('delete.tag', $tag->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    @endcan
    @can('add_tag')
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Tag</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('store.tag') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tag Name</label>
                        <input type="text" name="tag_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Tag</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection