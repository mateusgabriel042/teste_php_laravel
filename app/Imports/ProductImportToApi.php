<?php

namespace App\Imports;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '128M');

use App\Helper\Helpers;
use App\Http\ApiServices\MeliService;
use App\Models\Product;
use App\Models\Api;
use App\Models\ProductToApi;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImportToApi implements WithHeadingRow, ToCollection
{

    public $provider;
    public $quantity;
    public $api;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function __construct ($provider, $quantity, $api)
    {
        $this->provider = $provider;
        $this->quantity = $quantity;
        $this->api = $api;
    }

    public function collection($rows)
    {
        $settings = Api::query()->where('id', $this->api)->first();

        $count = 0;
        foreach ($rows as $key => $row) {

            $find = Product::where('id_provider', '=', $this->provider)
                ->where('supplier_product_code', '=', $row['supplier_product_code'])
                ->first();

            if (is_null($find)) {
                $suggestion['data'] = '';

                if ($row['title']) {
                    $suggestion = (new MeliService($this->api))->getCategoryPredictor($row['title']);
                }

                if(!$suggestion['data'])
                    continue;
                    
                if(is_object($suggestion['data'][0])){
                    $category = get_object_vars($suggestion['data'][0]);
                    $category = $category["category_id"];
                } else {
                    $category  = $suggestion['data'][0];
                }

                $product = [
                    'title' => $row['title'],
                    'photo' => Helpers::getImages($row['title']),
                    'brand' => $row['brand'] ?? "",
                    'stock' => $row['stock'] ?? 10,
                    'price_cost' => str_replace("R$","",$row['price']),
                    'price' => Helpers::getPrice(str_replace("R$","",$row['price'])),
                    'cat_ml_id' => $category,
                    'description' => $row['description'],
                    'condition' => $row['condition'] ?? "new",
                    'id_provider' => $this->provider,
                    'supplier_product_code' => $row['supplier_product_code'],
                ];

                $productCreated = Product::create($product);

                $data = [
                    "company" => $settings->company,
                    "api" => $settings->id,
                    "product_id" => $productCreated->id,
                    "listing_type_id" => ['gold_special']
                ];
    
                if ($this->verifyProductPublish($productCreated->id, $settings->id) == null) {
                    $prod = Product::publish($data);

                    if (isset($prod["success"]) and $prod["success"] == true) {
                        ProductToApi::create([
                            'checked' => true,
                            'id_pulish_ml' => $prod["data"]->id,
                            'id_products' => $productCreated->id,
                            'id_api' => $settings->id,
                            'link_api_publish_product' => $prod["data"]->permalink
                        ]);
                        $count ++;
                    }
                }

                if ($count == $this->quantity) {
                    break;
                }
            }
             else {

                 $find->title = $row['title'];
                 $find->photo = Helpers::getImages($row['title']);
                 $find->stock = $row['stock'] ?? 10;
                 $find->price_cost = str_replace("R$","",$row['price']);
                 $find->price = Helpers::getPrice(str_replace("R$","",$row['price']));
                 $find->description = $row['description'];
                 $find->condition = $row['condition'] ?? "new";
                 $find->save();

                 $data = [
                    "company" => $settings->company,
                    "api" => $settings->id,
                    "product_id" => $find->id,
                    "listing_type_id" => ['gold_special']
                ];
    
                if ($this->verifyProductPublish($find->id, $settings->id) == null) {
                    $prod = Product::publish($data);

                    if (isset($prod["success"]) and $prod["success"] == true) {
                        ProductToApi::create([
                            'checked' => true,
                            'id_pulish_ml' => $prod["data"]->id,
                            'id_products' => $find->id,
                            'id_api' => $settings->id,
                            'link_api_publish_product' => $prod["data"]->permalink
                        ]);
                        $count ++;
                    }
                }

                if ($count == $this->quantity) {
                    break;
                }
             }

        }
    }

    public function verifyProductPublish($id_product, $id_api)
    {
        return  ProductToApi::query()->where('id_products', $id_product)
            ->where("checked", true)
            ->where("id_api", $id_api)
            ->orderBy('id', 'desc')->first();
    }
}

