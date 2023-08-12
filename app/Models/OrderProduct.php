<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id' , 'created_at', 'updated_at'];

    //Order Product has many addons
    public function product(){
        return $this->belongsTo(Product::class);
    }
    //Order Product has many addons
    public function addons(){
        return $this->hasMany(OrderProductAddon::class,'order_product_id' , 'id');
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
