<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    function add_tag(){
        $tags = Tag::all();
        return view('backend.tag.tag', [
            'tags'=>$tags,
        ]);
    }
    function store_tag(Request $request){
        Tag::insert([
            'tag_name'=>$request->tag_name,
        ]);
        return back();
    }
    function delete_tag($id){
        Tag::find($id)->delete();
        return back();
    }
}
