<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use App\Models\Api;

class MercadoLivreService
{
    public function __construct() {}

    public function getApi()
    {
        return Api::find(Cache::get('user_system_id'));
    }

    public function httpClient()
    {
        $access_token = $this->getapi()['access_token'];

        return new Client([
            'base_uri' => 'https://api.mercadolibre.com',
            'headers' => [
                'Authorization' => 'Bearer ' . $access_token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
        ]);

    }

    public function refreshToken()
    {
        $api = $this->getApi();
        try {
            $cliente = new Client([
                'base_uri' => 'https://api.mercadolibre.com',
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
            ]);
            $response = $cliente->post('/oauth/token', [
                'json' => [
                    'grant_type' => 'refresh_token',
                    'client_id' => $api['app_id'],
                    'client_secret' => $api['secret_key'],
                    'refresh_token' => $api['refresh_token']
                ],
            ]);
            $responseBody = json_decode($response->getBody(), true);
            Api::where('id', $api['id'])->update([
                'access_token' => $responseBody['access_token']
            ]);
            return $responseBody;
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

}
