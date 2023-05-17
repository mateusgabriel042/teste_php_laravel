<?php

namespace App\Http\Controllers;

use App\Models\ProductToApi;
use Illuminate\Http\Request;

class ProductToApiController extends Controller
{
    public function index(Request $request)
    {
        $products = ProductToApi::join("products","products.id","product_to_apis.id_products")->paginate(10);
        return view('backend.product.list_publish', compact('products'));
    }
}
