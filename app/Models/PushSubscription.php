<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushSubscription extends Model
{
    protected $guarded = ['id' , 'created_at','updated_at'];
    use HasFactory;
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
