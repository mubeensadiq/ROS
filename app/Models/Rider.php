<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    //Rider Belongs to branch
    public function branch(){
        return $this->belongsTo(Branch::class , 'branch_id', 'id');
    }
}
