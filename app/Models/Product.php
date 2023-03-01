<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

    public function category_product()
    {
        return $this->belongsToMany(Category::class, 'category_product')->withTimestamps();
    }
}
