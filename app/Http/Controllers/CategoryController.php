<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;

class CategoryController extends Controller
{
    function add_category(){
        $categories = Category::all();
        $trashes = Category::onlyTrashed()->get();
        return view('backend.category.category', compact('categories', 'trashes'));
    }

    function store_category(Request $request){
        $request->validate([
            'category_name'=>['required', 'unique:categories'],
            'category_image'=>'required',
        ]);

        $slug  = strtolower(str_replace(' ', '-', $request->category_name));
        $cat_image =  $request->category_image;
        $extension = $cat_image->extension();
        $file_name = uniqid().'.'.$extension;
       
        $manager = new ImageManager(new Driver());
        $image = $manager->read($cat_image);
        $image->save(public_path('uploads/category/'.$file_name));

        Category::insert([
            'category_name'=>$request->category_name,
            'category_image'=>$file_name,
            'category_slug'=>$slug,
        ]);
        return back()->with('success', 'Category Added Successfully');

    }

    function category_delete($id){
        

        Subcategory::where('category_id', $id)->delete();
        Category::find($id)->delete();

        return  back()->with('del', 'Category Deleted Successfully');
    }

    function permanent_delete($id){
        $category_img = Category::onlyTrashed()->find($id)->category_image;
        $delete_from = public_path('uploads/category/'.$category_img);
        unlink($delete_from);

        Subcategory::where('category_id', $id)->delete();
        Category::onlyTrashed()->find($id)->forceDelete();

        return  back()->with('del', 'Category Deleted Successfully');

    }

    function restore($id){
        Category::onlyTrashed()->find($id)->restore();
        return back();
    }

    function add_subcategory(){
        $categories = Category::all();
        return view('backend.category.subcategory', [
            'categories'=>$categories,
        ]);
    }

    function store_subcategory(Request $request){
        Subcategory::insert([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success', 'Subcategory Added');
    }

    function del_subcategory($id){
        Subcategory::find($id)->delete();
        return back();
    }
}
