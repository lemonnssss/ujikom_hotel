<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function guest() {
        return $this->belongsTo(Guest::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'booking_room')->withTimestamps();
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function restaurantOrder() {
        return $this->hasOne(RestaurantOrder::class);
    }
}
