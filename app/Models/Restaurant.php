<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Restaurant extends Authenticatable
{
    protected $fillable = [
        'username', 'name', 'email', 'phone_no', 'address', 'password',
        'no_of_tables', 'operating_hours', 'description', 'img',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(RestaurantRating::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
