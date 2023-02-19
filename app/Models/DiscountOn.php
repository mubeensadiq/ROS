<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class DiscountOn extends Model
{
    protected $table = 'discount_on';
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    public function discountable(): MorphTo
    {
        return $this->morphTo();
    }

}
