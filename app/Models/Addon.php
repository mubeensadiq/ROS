<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function category(){
        return $this->belongsTo(AddonCategory::class,'addon_category_id','id');
    }
}
