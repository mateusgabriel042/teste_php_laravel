<?php

namespace App\Http\ApiServices;
ini_set('max_execution_time', 0);

use App\Models\Api;
use App\Models\SettingsApi;
use Illuminate\Support\Facades\Log;

class MeliService
{
    public $store;
    public $apiId;
    private $access_token;
    private $user;
    private $curl;
    private const URL = "https://api.mercadolibre.com";

    public function __construct($apiId=null)
    {
        $this->curl = curl_init();
        if($apiId)
        $settings = Api::query()->where('id', $apiId)->first();
        else
        $settings = Api::query()->where('company', 'Mercado Livre')->first();
        $this->access_token = $settings->access_token;
        $this->user = $settings->user;

    }


    public function getCategories()
    {
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL . "/sites/MLB/categories",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            Log::info('Ocorreu um erro ao capturar as categorias: ' . $err);
            return ['success' => false, 'data' => $err];
        } else {
            $categories = json_decode($response);
            return ['success' => true, 'data' => $categories];
        }
    }

    public function getSubCategories($category)
    {
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL . "/categories/{$category}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            Log::info('Ocorreu um erro ao capturar as categorias: ' . $err);
            return ['success' => false, 'data' => $err];
        } else {
            $categories = json_decode($response);
            return ['success' => true, 'data' => $categories];
        }
    }

    public function getUserMeli()
    {
        $this->refreshTokenMeli();
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL . "/users/me",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$this->access_token}",
            ),
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            $this->refreshTokenMeli();
            Log::info('Ocorreu um erro ao capturar o usuario: ' . $err);
            return ['success' => false, 'data' => $err];
        } else {
            $result = json_decode($response);
            if (!isset($result->id) && ($result->status == 401)) {
                $this->refreshTokenMeli();
                $this->getUserMeli();
            }

            $settings = Api::query()->where('company', 'Mercado Livre')
                ->update(['user'=> $result->id]);

            return ['success' => true, 'data' => $result];
        }
    }

    public function refreshTokenMeli()
    {
        $settings = Api::query()->where('company', 'Mercado Livre')->first();

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
        }
    }

    public function getRecentsOrders($seller_id)
    {

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL . "/orders/search?seller={$seller_id}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$this->access_token}",
            ),
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            Log::info('Ocorreu um erro ao capturar os pedidos: ' . $err);
            return ['success' => false, 'data' => $err];
        } else {
            return ['success' => true, 'data' => json_decode($response)];
        }
    }

    public function getCategoryPredictor($name)
    {
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL . "/sites/MLB/domain_discovery/search?limit=1&q=" . urlencode($name),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$this->access_token}",
            ),
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            Log::info('Ocorreu um erro ao capturar as sugestoes: ' . $err);
            return ['success' => false, 'data' => $err];
        } else {
            return ['success' => true, 'data' => json_decode($response)];
        }
    }

    public function getCategoryAttributes($category_id)
    {
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL . "/categories/{$category_id}/attributes",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$this->access_token}",
            ),
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            Log::info('Ocorreu um erro ao capturar as sugestoes: ' . $err);
            return ['success' => false, 'data' => $err];
        } else {
            return ['success' => true, 'data' => json_decode($response)];
        }
    }

    public function getListProducts($seller_id)
    {

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL . '/users/' . $seller_id . '/items/search',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$this->access_token}",
            ),
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            Log::info('Ocorreu um erro ao capturar os produtos: ' . $err);
            return ['success' => false, 'data' => $err];
        } else {
            return ['success' => true, 'data' => json_decode($response)];
        }
    }

    public function getShippingMethods()
    {

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL . "/users/{$this->user}/shipping_preferences",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            Log::info('Ocorreu um erro ao capturar os metodos de envio: ' . $err);
            return ['success' => false, 'data' => $err];
        } else {
            return ['success' => true, 'data' => json_decode($response)];
        }
    }

    public function getProduct($product_id)
    {

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL . '/items/' . $product_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$this->access_token}",
            ),
        ));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            Log::info('Ocorreu um erro ao capturar o produto: ' . $err);
            return ['success' => false, 'data' => $err];
        } else {
            return ['success' => true, 'data' => json_decode($response)];
        }
    }

    public function addProductMeli(array $params)
    {
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL . "/items",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer $this->access_token",
                "Content-Type:application/json"
            ),
            CURLOPT_POSTFIELDS => json_encode($params)));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            Log::info('Ocorreu um erro ao cadastrar produto: ' . $err);
            return ['success' => false, 'data' => $err];
        } else {
            $response = json_decode($response);
            if (isset($response->id)) {
                $data = (new MeliService())->addDescProductMeli($response->id, $params['description']);
                return ['success' => true, 'data' => $response];
            }
            return ['success' => false, 'data' => $response];
        }
    }

    public function editProductMeli($item, array $params)
    {
        //dd(self::URL . "/items/{$item}", $params);
        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL . "/items/{$item}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer $this->access_token",
                "Content-Type:application/json"
            ),
            CURLOPT_POSTFIELDS => json_encode($params)));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            Log::info('Ocorreu um erro ao Alterar o produto: ' . $err);
            return ['success' => false, 'data' => $err];
        } else {
            $response = json_decode($response);
            if (isset($response->id)) {
                //$data = (new MeliService())->addDescProductMeli($response->id, $params['description']);
                return ['success' => true, 'data' => $response];
            }
            return ['success' => false, 'data' => $response];
        }
    }

    public function addDescProductMeli($item, $text)
    {

        curl_setopt_array($this->curl, array(
            CURLOPT_URL => self::URL . "/items/{$item}/description",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer $this->access_token",
                "Content-Type:application/json"
            ),
            CURLOPT_POSTFIELDS => json_encode($text)));

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
            Log::info('Ocorreu um erro ao cadastrar produto: ' . $err);
            return ['success' => false, 'data' => $err];
        } else {
            return ['success' => true, 'data' => json_decode($response)];
        }
    }

}
