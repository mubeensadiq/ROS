<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiderProfile extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    protected $table = 'rider_profile';
    public function user(){
        return $this->belongsTo(User::class , 'user_id', 'id');
    }
    public function areas(){
        return $this->hasMany(RiderAreas::class,'rider_id' , 'id');
    }
}
