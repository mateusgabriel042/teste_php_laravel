<?php

namespace App\Http\Controllers;

use App\Helper\Helpers;
use App\Http\ApiServices\MeliService;
use App\Import\ImportProductsTest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Company;
use App\Models\ProductCategory;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Models\Api;
use App\Models\ProductToApi;
use App\Models\Provider;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function importProduct()
    {
        return view('backend.product.import-product');
    }



    // public function importExcel(Request $request){
    //     $data = ImportProductsTest::ImportProductsExcel($request->file);
    //     $line = 1;

    //     foreach($data as $item){

    //         if(count($item) >= 5){

    //             if($line > 0){
    //                 // dd("entriu");
    //                 if(!empty($item)){
    //                     // $suggestion = (new MeliService())->getCategoryPredictor( $item[1]);
    //                     // $category = $suggestion['data'][0];

    //                     // dd($category->category_id);
    //                      Product::insert([
    //                         'title' => $item[1],

    //                         'description' => $item[1],
    //                         'photo' => Helpers::getImages($item[1]),
    //                         'stock' => 10,

    //                         'condition' => "new",

    //                         'cat_id' => 1,
    //                         'child_cat_id',

    //                         'unity' => 10,

    //                         'supplier_product_code' => $item[0]
    //                        ]);
    //                     }
    //                     $line++;
    //             }
    //         }
    //     }
    // }
    public function index()
    {
        $products = Product::getAllProduct();
        $providers = Provider::all();
        $company = Company::all()->where('active', 1);
        $settings = Api::all();
        // return $products;
        return view('backend.product.index', compact('company', 'products', 'providers','settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brand = Brand::get();
        // $category=Category::where('is_parent',1)->get();
        $category = ProductCategory::all();
        // return $category;
        return view('backend.product.create')->with('categories', $category)->with('brands', $brand);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'string|required',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'required',
            'brand_id' => 'nullable',
            'child_cat_id' => 'nullable',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price_cost' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ]);

        $data = $request->all();

        $slug = Str::slug($request->title);
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
        $data['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');
        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }
        $data['price']= Helpers::getPrice("R$","",$data['price_cost']);
        // return $size;
        // return $data;
        $status = Product::create($data);
        if ($status) {
            request()->session()->flash('success', 'Product Successfully added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::get();
        $product = Product::findOrFail($id);
        $category = ProductCategory::all();
        $items = Product::where('id', $id)->get();
        // return $items;
        return view('backend.product.edit')->with('product', $product)
            ->with('brands', $brand)
            ->with('categories', $category)->with('items', $items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|required',
            'description' => 'string|nullable',
            'photo' => 'string|required',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'required',
            'brand_id' => 'nullable',
            'child_cat_id' => 'nullable',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price_cost' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');
        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }
        $data['price']= Helpers::getPrice($data['price_cost']);
        // return $data;
        $status = $product->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Product Successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $status = $product->delete();

        if ($status) {
            request()->session()->flash('success', 'Product successfully deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting product');
        }
        return redirect()->route('product.index');
    }

    public function verifyProductPublish($id_product, $id_api)
    {
        return  ProductToApi::query()->where('id_products', $id_product)
            ->where("checked", true)
            ->where("id_api", $id_api)
            ->orderBy('id', 'desc')->first();
    }
    public function publishProduct(Request $request)
    {

        $settings = Api::query()->where('id', $request->company)->orderBy('id', 'desc')->first();
        $products = Product::where("id_provider", $request->id_provider)->get();
        if ($products->count() > 0) {
            $call = new CallbackApiController();
            $call->refreshMercadoLivre($request);
        }
        $count = 0;

        foreach ($products as $key => $product) {

            // if($key <= 5974)
            // continue;

            $data = [
                "company" => $settings->company,
                "api" => $settings->id,
                "product_id" => $product->id,
                "listing_type_id" => $request->listing_type_id
            ];

            if ($this->verifyProductPublish($product->id, $settings->id) == null) {
                $prod = Product::publish($data);
            }

            if (isset($prod["success"]) and $prod["success"] == true) {
                ProductToApi::create([
                    'checked' => true,
                    'id_pulish_ml' => $prod["data"]->id,
                    'id_products' => $product->id,
                    'id_api' => $settings->id,
                    'link_api_publish_product' => $prod["data"]->permalink
                ]);
                $count ++;
            }
         if($count == $request->quantity)
         break;
        }

        if (isset($prod["success"]) and $prod["success"] == true) {
            return redirect()->back()->with('success', 'Produto publicado com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Ocorreu um erro ao anunciar produto');
        }

        if (isset($prod) or is_null($prod)) {
            return redirect()->back()->with('error', 'Ainda não há suporte de integração para a loja selecionada.');
        }
    }

    public function importForm()
    {
        $providers = Provider::all();
        return view('backend.product.import', compact('providers'));
    }

    public function import(Request $request)
    {
        $providers = Provider::all();
        Excel::import(new ProductImport($request->id_provider, $request->quantity), $request->file);
        return view('backend.product.import', ['message' => 'Produtos Importados com Sucesso!', 'providers' => $providers]);
    }
}
