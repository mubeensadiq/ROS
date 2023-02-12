<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id' , 'created_at', 'updated_at'];
    use HasFactory;

    //Product Belongs To Category
    public function category(){
        return $this->belongsTo(Category::class,'category_id' , 'id');
    }

    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'product_addons');
    }
    //Products Belongs To Categories
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function dealProducts(){
        return $this->belongsToMany(Category::class,'deal_products' )->withPivot('quantity');
    }
    public function schedule(){
        return $this->hasOne(ProductSchedule::class );
    }
}
