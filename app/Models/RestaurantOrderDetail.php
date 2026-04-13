<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantOrderDetail extends Model
{
    protected $guarded = [];

    public function menu() {
        return $this->belongsTo(RestaurantMenu::class, 'restaurant_menu_id');
    }
}
