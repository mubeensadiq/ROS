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
    //Products Belongs To Categories
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function addon_category_product(){
        return $this->hasMany(AddonCategoryProduct::class);
    }
    public function branch_product(){
        return $this->belongsToMany(Branch::class,'branch_product' )->withPivot('price');
    }
    public function schedule(){
        return $this->hasOne(ProductSchedule::class );
    }
}
