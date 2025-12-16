<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Gallery;
use App\Models\Tag;
use App\Models\Color;
use App\Models\Size;
use App\Models\Inventory;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Carbon\Carbon;

class ProductController extends Controller
{
    function add_product(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $tags = Tag::all();
        return view('backend.product.add', [
            'categories'=>$categories,
            'subcategories'=>$subcategories,
            'tags'=>$tags,
        ]);
    }

    function store_product(Request $request){
        $tags_id = implode(',', $request->tag_id);
        $slug  = strtolower(str_replace(' ', '-', $request->product_name));

        $preview =  $request->preview;
        $extension = $preview->extension();
        $file_name = uniqid().'.'.$extension;
       
        $manager = new ImageManager(new Driver());
        $image = $manager->read($preview );
        $image->save(public_path('uploads/product/preview/'.$file_name));

        $product_id = Product::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'tag_id'=>$tags_id,
            'product_name'=>$request->product_name,
            'slug'=>$slug,
            'discount'=>$request->discount,
            'short_desp'=>$request->short_desp,
            'long_desp'=>$request->long_desp,
            'preview'=>$file_name,
            'created_at'=>Carbon::now(),
        ]);

        foreach($request->gallery as $gal){
            $extension = $gal->extension();
            $file_name = uniqid().'.'.$extension;
        
            $manager = new ImageManager(new Driver());
            $image = $manager->read($gal);
            $image->save(public_path('uploads/product/gallery/'.$file_name));

            Gallery::insert([
                'product_id'=>$product_id,
                'gallery'=>$file_name,
            ]);
        }

        return back()->with('success', 'new product added!');

    }

    function product_list(){
        $products = Product::all();
        return view('backend.product.list', [
            'products'=>$products,
        ]);
    }

    function add_variant(){
        $colors = Color::all();
        $sizes = Size::all();
        return view('backend.product.variant',[
            'colors'=>$colors,
            'sizes'=>$sizes,
        ]);
    }

    function add_color(Request $request){
        Color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
        ]);
        return back();
    }

    function add_size(Request $request){
        Size::insert([
            'size_name'=>$request->size_name,
        ]);
        return back();
    }

    function inventory($id){
        $colors = Color::all();
        $sizes = Size::all();
        $product_info = Product::find($id);
        $inventories = Inventory::where('product_id', $id)->get();
        return view('backend.product.inventory', [
            'colors'=>$colors,
            'sizes'=>$sizes,
            'product_info'=>$product_info,
            'inventories'=>$inventories,
        ]);
    }

    function inventory_store(Request $request, $id){
        $product_info = Product::find($id);
        $discount = $product_info->discount;

        Inventory::insert([
            'product_id'=>$id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'price'=>$request->price,
            'price'=>$request->price,
            'discount_price'=>$request->price - ($request->price * $discount / 100),
            'quantity'=>$request->quantity,
        ]);

        return back();
    }
}
