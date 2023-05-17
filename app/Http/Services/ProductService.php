<?php

namespace App\Http\Services;

use App\Http\ApiServices\MeliService;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductSubCategory;
use App\Models\ProductCategory;

class ProductService
{
    public static function publishProductMeli($data)
    {
        
        $product = Product::query()->find($data['product_id']);
        $array_attributes = [];
        $array_images = [];
        $array_variations = [];
        // foreach ($product->attributes as $value) {
        //     $array_attributes[] = [
        //         'id' => $value->attribute_id,
        //         'value_name' => $value->attribute_name
        //     ];
        // }
        $array_attributes[] = ['id' => 'BRAND', 'value_name' => "BRAND"];
        //        $data['images'] =
        // array_push($data["images"], "https://i0.wp.com/meiaria.com.br/wp-content/uploads/2021/06/produto-teste.png?fit=800%2C800&ssl=1");
        array_shift($array_attributes);
        // foreach ($data['images'] as $value) {
        $array_images[] = ['source' => $product->photo];
        // }

        // foreach ($product->variations as $value) {
        $array_variations = array([
            "available_quantity" => $product->stock,
            'price' => $product->price,
            //                'sold_quantity'=>0,
            'picture_ids' => array(
                "https://i0.wp.com/meiaria.com.br/wp-content/uploads/2021/06/produto-teste.png?fit=800%2C800&ssl=1"
            )
            //                 'attribute_combinations' => array([
            //                     "id" => $value->variation_id,
            //                     "name" => $value->variation_name,
            // //                    "value_id" => (string)$value->quantity,
            //                     "value_name" => $value->value_name])

            //
        ]);

        // }

        $item = [
            "title" => $product->title,
            "category_id" =>   $product->cat_ml_id, //ProductSubCategory::find($product->child_cat_id)->category_id,
            "price" => $product->price,
            "currency_id" => "BRL",
            "available_quantity" => 0, //$product->stock,
            "buying_mode" => "buy_it_now",
            "condition" => "new",
            "video_id" => isset($product['youtube_id']) ? $product['youtube_id'] : null,
            "description" => ['plain_text' => $product->description],
            // "attributes" => ($array_attributes),
            "pictures" => $array_images,
            // "variations" => $array_variations,
            "accepts_mercadopago" => true,
            "non_mercado_pago_payment_methods" => [],
            "shipping" => [
                "mode" => "me2",
                //                "free_methods" => [
                //                    [
                ////                        "id" => 100009,
                //                        "rule" => [
                //                            "default" => true,
                //                            "free_mode" => "country",
                //                            "free_shipping_flag" => true,
                //                            "value" => null
                //                        ]
                //                    ]
                //                ],
                "tags" => [
                    "mandatory_free_shipping",
                    //                    "optional_me2_chosen"
                ],
                //                "dimensions" => "{$product->packing_height}x{$product->packing_wight}x{$product->packing_lenght}",
                //                "local_pick_up" => true,
                "free_shipping" => true,
                //                "logistic_type" => "drop_off",
                //                "store_pick_up" => false
            ]
        ];
       
        foreach ($data['listing_type_id'] as $type) {
            $item["listing_type_id"] = $type;
            $result = (new MeliService($data['api']))->addProductMeli($item);
        }
        

        return $result;
    }

    public static function updateProductMeli($data)
    {
        $product = Product::query()->find($data['product_id']);
        $array_images[] = ['source' => $product->photo];
        
        $item = [
            "title" => $product->title,
            "category_id" =>   $product->cat_ml_id, 
            "price" => $product->price,
            "available_quantity" => $product->stock,
            "condition" => $product->condition,
            "video_id" => isset($product->youtube_id) ? $product->youtube_id : null,
            //"description" => ['plain_text' => $product->description],
            "pictures" => $array_images
        ];

        if($product->stock == 0){
            $item['status'] = 'paused';
        }else {
            $item['status'] = 'active';
        }
        //dd($item);
        
        $result = (new MeliService($data['api']))->editProductMeli($data['id_pulish_ml'], $item);

        return $result;
    }

    public static function getVariations($category)
    {
        $variation = (new \App\Http\ApiServices\MeliService())->getCategoryAttributes($category);
        $data = [];
        foreach ($variation['data'] as $variation) {
            if (isset($variation->tags->allow_variations)) {
                $data[] = $variation;
            }
        }

        return $data;
    }

    public static function getProductsMeli()
    {
        $account = (new MeliService())->getUserMeli();
        $data = (new MeliService())->getListProducts($account['data']->id);
        $products = [];
        foreach ($data['data']->results as $key => $value) {
            $prod = (new MeliService())->getProduct($value);
            $products[$key] = $prod['data'];
        }

        return $products;
    }
}
