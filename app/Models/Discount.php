<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


class Discount extends Model
{
    use HasFactory;
    protected $guarded = ['id','created_at','updated_at'];

    /**
     * Get all of the cities that are assigned this discount.
     */
    public function cities(): MorphToMany
    {
        return $this->morphedByMany(City::class, 'discountable');
    }

    /**
     * Get all of the branches that are assigned this discount.
     */
    public function branches(): MorphToMany
    {
        return $this->morphedByMany(Branch::class, 'discountable');
    }

    /**
     * Get all of the products that are assigned this discount.
     */
    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'discountable');
    }

    /**
     * Get all of the categories that are assigned this discount.
     */
    public function categories(): MorphToMany
    {
        return $this->morphedByMany(Category::class, 'discountable');
    }
}
