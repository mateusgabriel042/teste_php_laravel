<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Api;
use App\Models\Provider;
use App\Models\ProductToApi;
use Illuminate\Support\Facades\Cache;
use App\Imports\ProductImportToApi;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Brand;
use App\Helper\Helpers;
use App\Http\ApiServices\MeliService;

class AnnouncementController extends Controller
{

    public $idApi;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->idApi = $request->id_api;
        return view('backend.announcement.index', $this->getDataIndex());
    }

    public function getDataIndex() {
        $accounts = Api::find(Cache::get('user_system_id'))
            ->where('status', 'active')
            ->get();

        $products = [];

        if ($this->idApi) {
            $products = ProductToApi::join("products", "products.id", "product_to_apis.id_products")
                ->where('id_api', $this->idApi)
                ->paginate(100);
        }
        return [
            'accounts' => $accounts,
            'products' => $products,
        ];
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $apis = Api::find(Cache::get('user_system_id'))
            ->where('status', 'active')
            ->get();
        $providers = Provider::all();
        
        return view('backend.announcement.import', [
            'apis' => $apis,
            'providers' => $providers,
        ]);
    }

    public function import(Request $request)
    {
        $providers = Provider::all();
        Excel::import(new ProductImportToApi($request->id_provider, $request->quantity, $request->id_api), $request->file);

        return redirect()->route('announcement.index', [
            'id_api' => $request->id_api
        ]);
    }

    public function alter(Request $request)
    {
        $this->idApi = $request->id_api;
        return view('backend.announcement.alter', $this->getDataIndex());
    }

    public function edit($id, $id_api)
    {
        
        $brand = Brand::get();
        $category = ProductCategory::all();
        $items = Product::where('id', $id)->get();
        $product = ProductToApi::join("products", "products.id", "product_to_apis.id_products")
                ->where('products.id', $id)
                ->where('product_to_apis.id_api', $id_api)
                ->first();
        //dd($product);
        return view('backend.announcement.edit')->with('product', $product)
                                                ->with('brands', $brand)
                                                ->with('categories', $category)
                                                ->with('items', $items);
    }

    public function update(Request $request, $id)
    {
        // Validar os dados do formulário
        $this->validate($request, [
            'title' => 'string|required',
            'summary' => 'string|nullable',
            'description' => 'string|nullable',
            'photo' => 'string|required',
            'size' => 'nullable',
            'stock' => "required|numeric",
            'cat_id' => 'nullable',
            'brand_id' => 'nullable',
            'child_cat_id' => 'nullable',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot',
            'price_cost' => 'required|numeric',
            'discount' => 'nullable|numeric'
        ]);

        // Buscar o produto e o anúncio no banco de dados
        $product = ProductToApi::join("products", "products.id", "product_to_apis.id_products")
                ->where('products.id', $id)
                ->where('product_to_apis.id_api', $request->company)
                ->first();

        // Buscar o produto para atualização dos dados        
        $item = Product::where('id', $id)->first();
        $settings = Api::query()->where('id', $request->company)->orderBy('id', 'desc')->first();

        //preparar dados dor formulario
        $data = $request->all();
        $data['is_featured'] = $request->input('is_featured', 0);
        $size = $request->input('size');
        if ($size) {
            $data['size'] = implode(',', $size);
        } else {
            $data['size'] = '';
        }
        $data['price']= Helpers::getPrice($data['price_cost']);

        //verificar se houve alteração
        $item->fill($data);
        $changes = $item->getDirty();
        foreach ($changes as $key => $value){
            $data2[$key] = $value;
        }

        if(isset($data2)){
            //atualizar informações do produto
            $status = $item->save();
            if (!$status) {
                request()->session()->flash('error', 'Please try again!!');
                return redirect()->route('announcement.alter', ['id_api' => $settings->id]);
            }
        }

        //Atualizar TOKEN
        $call = new CallbackApiController();
        $call->refreshMercadoLivre($request);

        //dados de configuraçao para API
        $config = [
            "company" => $settings->company,
            "api" => $settings->id,
            "product_id" => $product->id,
            "id_pulish_ml" => $product->id_pulish_ml
        ];

        //Atualizar as informações na API
        $prod = Product::edit($config);
        //dd($prod);

        if (isset($prod["success"]) and $prod["success"] == true) {
            request()->session()->flash('success', 'Announcement Successfully updated');
        }else{
            //PREPARAR PARA EXIBIR ERROS DA API
            $messages = '';
            if(!empty($prod['data']->cause)){
                $errors = $prod['data']->cause;
                foreach ($errors as $error) {
                    $messages .= $error->message."<br>";
                }
            }else{
                $messages = $prod['data']->message."<br>";
            }
            request()->session()->flash('error', $messages.'Please try again!!');
        }
       
        return redirect()->route('announcement.alter', ['id_api' => $settings->id]);

    }
}
