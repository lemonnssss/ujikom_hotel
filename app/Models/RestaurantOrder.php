<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantOrder extends Model
{
    protected $guarded = [];

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function booking() {
        return $this->belongsTo(Booking::class);
    }

    public function details() {
        return $this->hasMany(RestaurantOrderDetail::class);
    }

    public function guest() {
        return $this->belongsTo(Guest::class);
    }
}
