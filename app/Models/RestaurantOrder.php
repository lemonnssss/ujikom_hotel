<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantOrder extends Model
{
    protected $guarded = [];

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function details() {
        return $this->hasMany(RestaurantOrderDetail::class);
    }
}
