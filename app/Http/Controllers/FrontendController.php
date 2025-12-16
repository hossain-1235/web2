<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Inventory;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\OrderProduct;
use App\Models\Cart;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FrontendController extends Controller
{

function index(){
    $top_selling = OrderProduct::groupBy('product_id')
        ->selectRaw('sum(quantity) as sum, product_id')
        ->orderBy('sum', 'DESC')->take(3)->get();
    $categories = Category::all();
    $products = Product::all();
    $recent_products = Product::latest()->take(3)->get();
    return view('frontend.index', [
        'categories'=>$categories,
        'products'=>$products,
        'recent_products'=>$recent_products,
        'top_selling'=>$top_selling,
    ]);
}

function product_details($slug){
    $product_id = Product::where('slug', $slug)->first()->id;
    $reviews = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->get();
    $total_reviews = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->count();
    $product_info = Product::find($product_id);
    $total_stars = OrderProduct::where('product_id', $product_id)->whereNotNull('review')->sum('rating');
    $similler_products = Product::where('category_id', $product_info->category_id)->where('id', '!=' , $product_id)->get();
    $available_colors = Inventory::where('product_id', $product_id)
        ->groupBy('color_id')
        ->selectRaw('sum(color_id) as sum, color_id')
        ->get();
    $available_sizes = Inventory::where('product_id', $product_id)
        ->groupBy('size_id')
        ->selectRaw('sum(size_id) as sum, size_id')
        ->get();

    $shareButtons = \Share::page(

            'https://www.itsolutionstuff.com',

            'Your share text comes here',

        )
        ->facebook()
        ->twitter()
        ->linkedin()
        ->telegram()
        ->whatsapp()        
        ->reddit();

  
    return view('frontend.product_details', [
        'product_info'=>$product_info,
        'available_colors'=>$available_colors,
        'available_sizes'=>$available_sizes,
        'similler_products'=>$similler_products,
        'reviews'=>$reviews,
        'total_reviews'=>$total_reviews,
        'total_stars'=>$total_stars,
        'shareButtons'=>$shareButtons,
    ]);
}

function customer_register(){
    return view('frontend.register');
}
function customer_login(){
    return view('frontend.login');
}

function checkout(Request $request){
    $carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
    $coupon = $request->coupon; 
    $coupon_discount = 0;
    if($coupon){
        if(Coupon::where('coupon', $coupon)->exists()){
            if(Carbon::now()->format('Y-m-d') <= Coupon::where('coupon', $coupon)->first()->validity){
                $coupon_discount = Coupon::where('coupon', $coupon)->first()->amount;
            }
            else{
                return back()->with('not_exist', 'Coupon Code Expired');
            }
        }
        else{
            return back()->with('not_exist', 'Invalid Coupon Code');
        }
    }
    $countries = Country::all();
    $cities = City::all();
    return view('frontend.checkout', [
        'carts'=>$carts,
        'coupon_discount'=>$coupon_discount,
        'countries'=>$countries,
        'cities'=>$cities,
    ]);
}

function search_product(Request $request){
    $search_products = Product::
    where('product_name', 'like', '%' . $request->keyword . '%')
    ->orWhere('short_desp', 'like', '%' . $request->keyword . '%')
    ->orWhere('long_desp', 'like', '%' . $request->keyword . '%')
    ->get();
    
    return view('frontend.search', [
        'search_products'=>$search_products,
    ]);
}

function review(Request $request, $id){
   OrderProduct::where('customer_id', Auth::guard('customer')->id())->where('product_id',$id)->first()->update([
    'rating'=>$request->rating,
    'review'=>$request->review,
   ]);
   return back()->with('review', 'review submitted');
}

function category_product($slug){
    $category = Category::where('category_slug', $slug)->first();
    $products = Product::where('category_id', $category->id)->get();
    return view('frontend.category_product', [
        'products'=>$products,
        'category'=>$category,
    ]);
}

}
