<?php

namespace App\Http\Controllers;

use App\Models\Api;
use App\Models\SettingsApi;
use Illuminate\Http\Request;

class CallbackApiController extends Controller
{
    public function authorizeMercadoLivre(Request $request)
    {
        // https://127.0.0.1:8000/callback/mercadolivre?code=TG-638266ed80603e00011493a0-13134619

        if (isset($request->code)) {
            $settings = Api::query()->where('id', $request->company)->orderBy('id', 'desc')->first();

            $params = [
                'grant_type' => 'authorization_code',
                'client_id' => $settings->app_id,
                'client_secret' => $settings->secret_key,
                'code' => $request->code,
                'redirect_uri' => $settings->url_redirect,
                'site_id' => 'MLB'
            ];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.mercadolibre.com/oauth/token",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($params)
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $response = json_decode($response);
                $settings->update([
                    'access_token' => $response->access_token,
                    'refresh_token' => $response->refresh_token
                ]);
                return redirect()->back()->with('success', 'Api autorizada com sucesso!');
            }
        }
    }

    public function refreshMercadoLivre(Request $request)
    {
        $settings = Api::query()->where('id', $request->company)->orderBy('id', 'desc')->first();
        

        $params = [
            'grant_type' => 'refresh_token',
            'client_id' => $settings->app_id,
            'client_secret' => $settings->secret_key,
            'refresh_token' => $settings->refresh_token
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.mercadolibre.com/oauth/token?" . http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response);
            $settings->update([
                'access_token' => $response->access_token,
                'refresh_token' => $response->refresh_token
            ]);

            // dd($response)
            return redirect()->back()->with('success', 'Token de Api atualizado com sucesso!');
        }
    }


    public function addProductMercadoLivre(Request $request)
    {

        $settings = Api::query()->where('id', $request->company)->orderBy('id', 'desc')->first();
        $item = array(
            "title" => "Item de test - No Ofertar",
            "category_id" => "MLA3530",
            "price" => 350,
            "currency_id" => "ARS",
            "available_quantity" => 10,
            "buying_mode" => "buy_it_now",
            "condition" => "new",
            "listing_type_id" => "gold_special",
            "sale_terms" => [
                [
                    "id" => "WARRANTY_TYPE",
                    "value_name" => "Garantía del vendedor"
                ],
                [
                    "id" => "WARRANTY_TIME",
                    "value_name" => "90 días"
                ]
            ],
            "pictures" => [
                // "source" => "http://mla-s2-p.mlstatic.com/968521-MLA20805195516_072016-O.jpg"
            ],
            "attributes" => [
                [
                    "id" => "BRAND",
                    "value_name" => "Marca del producto"
                ],
                [
                    "id" => "EAN",
                    "value_name" => "7898095297749"
                ]

            ]
            // "title" => "Produto teste",
            // "category_id" => "MLB1540",
            // "price" => 789654,
            // "currency_id" => "BRL",
            // "available_quantity" => 123,
            // "buying_mode" => "classified",
            // "listing_type_id" => "bronze",
            // "condition" => "new",
            // //            "description" => array ("plain_text" => "Lorem Ipsum"),
            // //            "warranty" => "12 meses pela fábrica",
            // //            "pictures" => array(
            // //                array(
            // //                    "source" => $pic
            // //                )
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.mercadolibre.com/items",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer $settings->access_token",
            ),
            CURLOPT_POSTFIELDS => json_encode($item)
        ));


        $response = curl_exec($curl);
        $err = curl_error($curl);


        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}
