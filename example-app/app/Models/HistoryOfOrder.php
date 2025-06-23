<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryOfOrder extends Model
{
    use HasFactory;

    protected $table = 'history_of_orders';  
    protected $fillable = [
        'user_id', 
        'offer_id', 
        'quantity', 
        'paid'
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        return $this->belongsTo(FoodOffer::class, 'offer_id');
    }
    
}
