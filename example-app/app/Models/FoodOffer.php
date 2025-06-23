<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'name',
        'description',
        'price',
        'quantity',
        'image_path',
        'cuisine_type',
        'caloric_content',
        'dietary_restrictions'  
    ];
    public function activeOrders()
    {
        return $this->hasMany(ActiveOrder::class, 'offer_id');
    }
        public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
    
    public function unpublish()
    {
        $this->update(['quantity' => 0]);
    }

    public function publish($quantity)
    {
        $this->update(['quantity' => $quantity]);
    }
}
