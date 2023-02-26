<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id' , 'created_at' , 'updated_at'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function discount(): MorphToMany
    {
        return $this->morphToMany(Discount::class , 'discountable');
    }
}
