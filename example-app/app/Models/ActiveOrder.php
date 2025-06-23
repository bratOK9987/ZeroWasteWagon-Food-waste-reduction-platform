<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'offer_id',
        'quantity',
        'paid'
    ];
    
    public function offer()
    {
        return $this->belongsTo(FoodOffer::class, 'offer_id');
    }
    
    
}
