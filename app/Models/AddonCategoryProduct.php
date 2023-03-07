<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddonCategoryProduct extends Model
{
    protected $guarded = ['id' , 'created_at', 'updated_at'];
    use HasFactory;

    public function addons(){
        return $this->belongsToMany(Addon::class );
    }
    public function category(){
        return $this->belongsTo(AddonCategory::class , 'addon_category_id' );
    }
}
