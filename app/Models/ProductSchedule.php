<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSchedule extends Model
{
    protected $table = 'product_schedule';
    protected $guarded = ['id' , 'created_at', 'updated_at'];
    use HasFactory;
}
