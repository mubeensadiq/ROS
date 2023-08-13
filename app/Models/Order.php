<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id' , 'created_at', 'updated_at'];
    protected $appends = ['customer_name'];

    //Order has many Products
    public function products(){
        return $this->hasMany(OrderProduct::class,'order_id' , 'id');
    }

    public function rider(){
        return $this->hasOne(OrderRider::class);
    }
    public function branch(){
        return $this->belongsTo(Branch::class,'branch','id');
    }
    public function area(){
        return $this->belongsTo(Area::class , 'area' , 'id');
    }

    protected function getCustomerNameAttribute()
    {
        return $this->first_name. ' ' .$this->last_name;
    }
}
