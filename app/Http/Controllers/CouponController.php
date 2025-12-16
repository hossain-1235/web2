<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponController extends Controller
{
    function coupon(){
        $coupons = Coupon::all();
        return view('backend.coupon.coupon', [
            'coupons'=>$coupons,
        ]);
    }

    function add_coupon(Request $request){
        Coupon::insert([
            'coupon'=>$request->coupon,
            'amount'=>$request->amount,
            'validity'=>$request->validity,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }
}
