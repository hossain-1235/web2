<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    function rel_to_city(){
        return $this->belongsTo(City::class, 'city_id');
    }
    function rel_to_country(){
        return $this->belongsTo(Country::class, 'country_id');
    }

    protected $guarded = ['id'];
}
