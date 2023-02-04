<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $guarded = ['id' , 'created_at', 'updated_at'];


    //Area Belongs To City
    public function city(){
        return $this->belongsTo(City::class,'city_id' , 'id');
    }
    public function branches()
    {
        return $this->belongsToMany(Branch::class);
    }
}
