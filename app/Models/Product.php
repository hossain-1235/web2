<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    function rel_to_inv(){
        return $this->hasMany(Inventory::class, 'product_id');
    }
    function rel_to_category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
    function rel_to_gallery(){
        return $this->hasMany(Gallery::class, 'product_id');
    }
}
