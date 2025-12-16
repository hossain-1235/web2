<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CartController extends Controller
{
    function getSize(Request $request){
        $str = '';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        
        foreach ($sizes as $size) {
            if ($size->rel_to_size->size_name == 'NA') {
                $str .= '<div class="form-check size-option form-option form-check-inline mb-2">
                    <input class="form-check-input size_id" type="radio" name="size_id" id="size'.$size->size_id.'" value="'.$size->size_id.'" checked>
                    <label class="form-option-label" for="size'.$size->size_id.'">'.$size->rel_to_size->size_name.'</label>';
            } else {
                $str .= '<div class="form-check size-option form-option form-check-inline mb-2">
                    <input class="form-check-input size_id" type="radio" name="size_id" id="size'.$size->size_id.'" value="'.$size->size_id.'">
                    <label class="form-option-label" for="size'.$size->size_id.'">'.$size->rel_to_size->size_name.'</label>';
            }

        }
        echo $str;
    }

    function getQuantity(Request $request){
         $str = '';
         $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity;

         $price = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->price;

         $discount_price = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->discount_price;
         
         if ($quantity == 0) {
            $str = '<strong id="quan" class="text-warning" >Out of Stock</strong>';
        } else {
            $str = '<strong id="quan" class="text-success" >' . $quantity . ' In Stock</strong>';
        }
        return response()->json(['quantity' => $str, 'price' => $price, 'discount_price'=>$discount_price]);
    }

    function add_cart(Request $request){
    
        if(Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity > 0){
            if(Cart::where('customer_id', Auth::guard('customer')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){

            Cart::where('customer_id', Auth::guard('customer')->id())->where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
            return back()->with('cart', 'Cart Added Successfully');
            }
            else{
                Cart::insert([
                    'customer_id'=>Auth::guard('customer')->id(),
                    'product_id'=>$request->product_id,
                    'color_id'=>$request->color_id,
                    'size_id'=>$request->size_id,
                    'quantity'=>$request->quantity,
                    'created_at'=>Carbon::now(),
                ]);
                return back()->with('cart', 'Cart Added Successfully');
            }
        }
        else{
            return back()->with('outstock', 'out of Stock');
        }
        
    }
    function remove_cart($id){
        Cart::find($id)->delete();
        return back();
    }
}
