@extends('layouts.admin')
@section('content')
<div class="row">
    @can('role')
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Role List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Role</th>
                        <th>Permission</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($roles as $index=>$role)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td class="text-wrap">
                            @foreach ($role->getPermissionNames() as $permission)
                                <span class="my-1 badge badge-primary">{{ $permission }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('delete.role', $role->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="mt-3 card">
            <div class="card-header">
                <h3>User List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $index=>$user)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td class="text-wrap">
                            @foreach ($user->getRoleNames() as $role)
                                <span class="my-1 badge badge-primary">{{ $role }}</span>
                            @endforeach
                        </td>
                        <td>
                            @if ($user->getRoleNames()->isNotEmpty())
                                <a href="{{ route('remove.role', $user->id) }}" class="btn btn-danger">Remove Role</a>
                            @endif
                            
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Permission</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('create.permission') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Permission Name</label>
                        <input type="text" name="permission" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Permission</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-3 card">
            <div class="card-header">
                <h3>Add Role</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('add.role') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Role Name</label>
                        <input type="text" name="role_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <h4>Select Permission</h4>
                        @foreach ($permissions as $permission) 
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input type="checkbox" name="permission[]" value="{{ $permission->name }}" class="form-check-input">
                                {{ $permission->name }}
                                <i class="input-frame"></i></label>
                        </div>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Role</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mt-3 card">
            <div class="card-header">
                <h3>Assign Role</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('assign.role') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select User</label>
                        <select name="user" class="form-control">
                            <option value="">Select User</option>
                            @foreach ($users as $user)                            
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Select Role</label>
                        <select name="role" class="form-control">
                            <option value="">Select Role</option>
                            @foreach ($roles as $role)                            
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Assign Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <div>
        <h3>you dont have permission to see this page</h3>
    </div>
    @endcan
</div>
@endsection