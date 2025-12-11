<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_product_id',
        'ingredient_product_id',
        'quantity_used',
    ];

    public function menu()
    {
        return $this->belongsTo(Product::class, 'menu_product_id');
    }

    public function ingredient()
    {
        return $this->belongsTo(Product::class, 'ingredient_product_id');
    }
}