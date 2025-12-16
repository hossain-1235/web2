<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function role_manager(){
        $permissions = Permission::all();
        $roles = Role::all();
        $users = User::all();
        return view('backend.role.role', [
            'permissions'=>$permissions,
            'roles'=>$roles,
            'users'=>$users,
        ]);
    }
    function create_permission(Request $request){
        Permission::create(['name' => $request->permission]);
        return back();
    }

    function add_role(Request $request){
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);

        return back();
    }

    function assign_role(Request $request){
        $user = User::find($request->user);
        $user->assignRole($request->role);

        return back();
    }

    function remove_role($id){
        $user = User::find($id);
        $user->syncRoles([]);
        $user->syncPermissions([]);
        return back();
    }

    function delete_role($role_id){
        $role = Role::find($role_id);
        $role->syncPermissions([]);
        $role->delete();
        return back();
    }
}
