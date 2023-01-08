<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderAreas extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    public function area(){
        return $this->belongsTo(Area::class , 'area_id', 'id');
    }
    public function rider(){
        return $this->belongsTo(RiderProfile::class , 'rider_id', 'id');
    }
}
