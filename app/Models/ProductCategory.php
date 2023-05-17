<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    // use HasFactory;

    protected $table = 'products_categories';

    protected $fillable = ['category_id', 'name'];

    public function subcategories()
    {
        return $this->hasMany(ProductSubCategory::class, 'parent_category');
    }


}
