<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    // use HasFactory;
    protected $table = 'products_subcategories';

    protected $fillable = ['parent_category','category_id', 'name'];

    public function categories()
    {
        return $this->hasMany(ProductSubCategory::class, 'parent_category');
    }
}
