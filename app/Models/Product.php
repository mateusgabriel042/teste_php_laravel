<?php

namespace App\Models;

use App\Http\Services\ProductService;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;

class Product extends Model
{
    protected $fillable = ['title','cat_ml_id','slug', 'summary', 'description', 'cat_id', 'child_cat_id','price_cost', 'price', 'brand_id', 'discount', 'status', 'photo', 'size', 'stock', 'is_featured', 'condition', 'name', 'unity', 'packing', 'subpackaging', 'mult_v', 'width', 'height', 'depth',  'supplier_product_code', 'id_provider'];

    public function cat_info()
    {
        return $this->hasOne('App\Models\Category', 'id', 'cat_id');
    }
    public function sub_cat_info()
    {
        return $this->hasOne('App\Models\Category', 'id', 'child_cat_id');
    }
    public static function getAllProduct()
    {
        return Product::with(['cat_info', 'sub_cat_info'])->orderBy('id', 'asc')->paginate(10);
    }
    public function rel_prods()
    {
        return $this->hasMany('App\Models\Product', 'cat_id', 'cat_id')->where('status', 'active')->orderBy('id', 'DESC')->limit(8);
    }
    public function getReview()
    {
        return $this->hasMany('App\Models\ProductReview', 'product_id', 'id')->with('user_info')->where('status', 'active')->orderBy('id', 'DESC');
    }
    public static function getProductBySlug($slug)
    {
        return Product::with(['cat_info', 'rel_prods', 'getReview'])->where('slug', $slug)->first();
    }
    public static function countActiveProduct()
    {
        $data = Product::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }

    public function carts()
    {
        return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class)->whereNotNull('cart_id');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public static function publish($data)
    {
        switch ($data['company']) {
            case 'Mercado Livre':
                return ProductService::publishProductMeli($data);
            default:
                return null;
        }
    }

    public static function edit($data)
    {
        switch ($data['company']) {
            case 'Mercado Livre':
                return ProductService::updateProductMeli($data);
            default:
                return null;
        }
    }
}
