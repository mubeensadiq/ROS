<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = ['id' , 'created_at', 'updated_at'];
    use HasFactory;

    //Branch Belongs To Area
    public function areas(){
        return $this->belongsToMany(Area::class);
    }

    //Branch Belongs To Area
    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('price');
    }
}
