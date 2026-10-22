<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $fillable = [
        'username', 'name', 'email', 'phone_no', 'address', 'password', 'img',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function menuRatings(): HasMany
    {
        return $this->hasMany(MenuRating::class);
    }

    public function restaurantRatings(): HasMany
    {
        return $this->hasMany(RestaurantRating::class);
    }
}
