<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'unit_id',
        'type',
        'sku',
        'name',
        'sale_price',
        'purchase_price',
        'stock_minimum',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function recipeIngredients()
    {
        return $this->hasMany(Recipe::class, 'menu_product_id');
    }

    public function usedInRecipes()
    {
        return $this->hasMany(Recipe::class, 'ingredient_product_id');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}