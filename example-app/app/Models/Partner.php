<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Partner extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'venue_type', 'venue_name', 'address', 'website', 'venue_phone_number',
        'venue_city', 'venue_country', 'email', 'password', 'latitude', 'longitude'
    ];

    protected $hidden = ['password'];

    public function offers()
    {
        return $this->hasMany(FoodOffer::class, 'partner_id', 'id');
    }
    
    public function pickupTimes()
    {
        return $this->hasMany(PickupTime::class);
    }
}

