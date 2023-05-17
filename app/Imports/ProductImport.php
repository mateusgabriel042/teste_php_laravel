<?php

namespace App\Imports;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '128M');

use App\Helper\Helpers;
use App\Http\ApiServices\MeliService;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductImport implements WithHeadingRow, ToCollection
{

    public $provider;
    public $quantity;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function __construct ($provider, $quantity)
    {
        $this->provider = $provider;
         $this->quantity = $quantity;
    }


    public function collection($rows)
    {
        $count = 0;
        foreach ($rows as $key => $row) {

                $find = Product::where('id_provider', '=', $this->provider)
                ->where('supplier_product_code', '=', $row['supplier_product_code'])
                ->first();
            if (is_null($find)) {
                $suggestion = (new MeliService())->getCategoryPredictor($row['title']);
                if(!$suggestion['data'])
                continue;
                if(is_object($suggestion['data'][0])){
                    $category = get_object_vars($suggestion['data'][0]);
                    $category = $category["category_id"];
                }
                else
                $category  = $suggestion['data'][0];
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

                Product::create($product);
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
                  if ($count == $this->quantity) {
                      break;
                  }
             }

        }
    }
}
