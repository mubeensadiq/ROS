<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = ['id' , 'created_at', 'updated_at'];
    use HasFactory;

    //Branch Belongs To Area
    public function area(){
        return $this->belongsTo(Area::class,'area_id' , 'id');
    }
}
