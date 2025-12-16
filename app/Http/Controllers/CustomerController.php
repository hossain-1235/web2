<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PassReset;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PassResetNotification;

class CustomerController extends Controller
{
    function customer_store(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>['required', 'unique:customers'],
            'password'=>['required', 'confirmed'],
            'password_confirmation'=>'required',
        ]);
        Customer::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);

         if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' =>        $request->password])) {
            return redirect()->route('index');
        }
        // return back()->with('success', 'Registered Successfully');
    }

    function customer_signin(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
        ]);
        if(Customer::where('email', $request->email)->exists()){
            if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('index');
            }
            else{
                return back()->with('wrong_pass', 'Wrong Password');
            }
        }
        else{
            return back()->with('nt_exists', 'Email Does not Exist');
        }

    }

    function customer_profile(){
        return view('frontend.profile');
    }

    function customer_logout(){
        Auth::guard('customer')->logout();
        return redirect()->route('customer.login');
    }

    function customer_update(Request $request){
        if($request->password){
            if($request->photo){
                //password ache and photo ache

                if(password_verify($request->current_password, Auth::guard('customer')->user()->password)){
                    if(Auth::guard('customer')->user()->photo != null){
                        $delete_from = public_path('uploads/customer/'.Auth::guard('customer')->user()->photo);
                        unlink($delete_from);
                    }
                    $extension = $request->photo->extension();
                    $file_name = uniqid().'.'.$extension;
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($request->photo);
                    $image->save(public_path('uploads/customer/'.$file_name));

                    Customer::find(Auth::guard('customer')->id())->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'country'=>$request->country,
                        'address'=>$request->address,
                        'password'=>bcrypt($request->password),
                        'photo'=>$file_name,
                    ]);
                    return back()->with('success', 'Profile updated');
                }
                else{
                    return back()->with('wrong_current', 'Current Password Incorrect');
                }
            }
            else{
                //password ache and photo nai
                if(password_verify($request->current_password, Auth::guard('customer')->user()->password)){

                    Customer::find(Auth::guard('customer')->id())->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'country'=>$request->country,
                        'address'=>$request->address,
                        'password'=>bcrypt($request->password),
                    ]);
                    return back()->with('success', 'Profile updated');
                }
                else{
                    return back()->with('wrong_current', 'Current Password Incorrect');
                }
            }
        }
        else{
            if($request->photo){
                //password nai and photo ache
                if(Auth::guard('customer')->user()->photo != null){
                    $delete_from = public_path('uploads/customer/'.Auth::guard('customer')->user()->photo);
                    unlink($delete_from);
                }
                $extension = $request->photo->extension();
                $file_name = uniqid().'.'.$extension;
                $manager = new ImageManager(new Driver());
                $image = $manager->read($request->photo);
                $image->save(public_path('uploads/customer/'.$file_name));

                Customer::find(Auth::guard('customer')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'address'=>$request->address,
                    'photo'=>$file_name,
                ]);
                return back()->with('success', 'Profile updated');
            }
            else{
                //password nai and photo nai
                Customer::find(Auth::guard('customer')->id())->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'country'=>$request->country,
                    'address'=>$request->address,
                ]);
                return back()->with('success', 'Profile updated');
            }
        }
    }

    function customer_orders(){
        $myorders = Order::where('customer_id', Auth::guard('customer')->id())->get();
        return view('frontend.orders', [
            'myorders'=>$myorders
        ]);
    }

    function invoice_dowload($order_id){
        $pdf = Pdf::loadView('mail.downloadinvoice', [
            'order_id'=>$order_id
        ]);
        return $pdf->download('invoice.pdf');
    }

    function forgot_password(){
        return view('frontend.forgot_password');
    }

    function send_password_request(Request $request) {
        if(Customer::where('email', $request->email)->exists()){
            $token = uniqid();
            $customer = Customer::where('email', $request->email)->first();

            if(PassReset::where('customer_id', $customer->id)->exists()){
                PassReset::where('customer_id', $customer->id)->delete();
            }
      
            PassReset::insert([
                'token'=>$token,
                'customer_id'=>$customer->id,
            ]);
        
            
            Notification::send($customer, new PassResetNotification($token));
        }
        else{
            return back()->with('notExist', 'Email Does not exist');
        }
    }

    function pass_reset_form($token){
        return view('frontend.pass_reset_form', [
            'token'=>$token,
        ]);
    }

    function pass_reset_confirm(Request $request,$token){
        $customer = PassReset::where('token', $token)->first();

        if(PassReset::where('token', $token)->exists()){
            $request->validate([
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ]);

           Customer::where('id', $customer->id)->update([
                'password'=>bcrypt($request->password)
           ]);

            PassReset::where('token', $token)->delete();

            return back()->with('success',  'Password Changed');
        }
        else{
            return back()->with('expired',  'Link Expired, Request Again');
        }
    }

}
