<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupTime extends Model
{
    use HasFactory;

    protected $fillable = ['partner_id', 'day_of_week', 'start_time', 'end_time'];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }
}