<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    function edit_profile(){
        return view('backend.user.edit_profile');
    }
    function update_profile(Request $request){
        if($request->photo){
            $request->validate([
                'photo'=>'mimes:png,jpg',
                'photo'=>'file|max:1024',
            ]);

            if(Auth::user()->photo != null){
                $delete_from = public_path('uploads/users/'.Auth::user()->photo);
                unlink($delete_from);
            }

            $extenstion = $request->photo->extension();
            $file_name = uniqid().'.'.$extenstion;
            
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->photo);
            $image->save(public_path('uploads/users/'.$file_name));

            User::find(Auth::id())->update([
                'name'=>$request->name,
                'photo'=>$file_name,
            ]);
            return back()->with('success', 'Profile Updated');
        }
        else{
            User::find(Auth::id())->update([
                'name'=>$request->name,
            ]);
             return back()->with('success', 'Profile Updated');
        }
    }

    function update_password(Request $request){
        $request->validate([
            'current_password'=>'required',
            'password'=>[
                'required', 
                'confirmed',
                Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
            ],
            'password_confirmation'=>'required',
        ]);

        if(Hash::check($request->current_password, Auth::user()->password)){
            User::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
            ]);
            return back()->with('pass_update', 'Password Changed');
        }
        else{
            return back()->with('wrong', 'Current Password Not Match');
        }
    }
}
