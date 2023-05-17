<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

// use Shopee\Client;

require __DIR__ .'../../../vendor/autoload.php';

//apis
require __DIR__ .'../../../api/shopee-php/src/Client.php';
//..
require __DIR__ .'../../../api/magalu-php-skd/src/Marketplace.php';

//..
require __DIR__ .'../../../api/mercadolibre/src/RestClientApi.php';

//..
require __DIR__ .'../../../api/olist-api-client-php/autoload.php';

//..
require __DIR__ .'../../../api/amazonproductapi/src/AmazonAPI.php';
require __DIR__ .'../../../api/amazonproductapi/src/AmazonUrlBuilder.php';

//..
// require __DIR__ .'../../../api/submarino-americanas/src/Client.php';

//..
require __DIR__ .'../../../api/cnova-casasbahia/src/Client/Client.php';

//..
// require __DIR__ .'../../../api/cnova-casasbahia/src/Client/Client.php';
// require __DIR__ .'../../../api/cnova-casasbahia/src/Client/Factory.php';


class Functions extends Controller
{

    public static function connect(){

    }
    public static function shopee(){

        $client = new Client([
            'secret' => getenv('SHOPEE_PARTNER_KEY'),
            'partner_id' => getenv('SHOPEE_PARTNER_ID'),
            'shopid' => getenv('SHOPEE_SHOP_ID'),
        ]);

        $response = $client->item->getItemDetail(['item_id' => 1978]);

        // $parameters = (new \Shopee\Nodes\Item\Parameters\GetItemDetail())
        //     ->setItemId(1978);
        // $response = $client->item->getItemDetail($parameters);

        // return
        
    }
    public static function casasbahia(){

        // casas Bahia,  Extra e Ponto Frio

        $produtosCadastrados = $manager->fetch(); // Collection de Objetos Product

        $cnovaSdk = Factory::getInstance()->setup([
            'client_id'     => 'foo',
            'access_token'  => 'bar',
            'version'       => 'sandbox',
         ]);
        
        $manager = $cnovaSdk->factoryManager('product');

        // $produto = $manager->findById(9)); // Objeto Produto
        // echo $product->getTitle(); // Acesso ao nome do produto de Id 9

    }
    public static function magalu(){

        $skyhub = new Skyhub\Marketplace();
        $skyhub->setAuth('<user_skyhub>', '<api_key>');

        // $produto = $skyhub->products()->insert([
        //     'sku'=>'72350973',
        //     'name'=>'Teste de produto',
        //     'description'=>'Produto de teste da API'
        // ]);

        $produtos = $skyhub->products()->get(1, 10);

        // return

    }

    public static function mercadolivre(){
        
        $apiInstance = new Meli\Api\OAuth20Api(
            // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
            // This is optional, `GuzzleHttp\Client` will be used as default.
            new GuzzleHttp\Client()
        );
        $grant_type = 'authorization_code';
        $client_id = 'client_id_example'; // Your client_id
        $client_secret = 'client_secret_example'; // Your client_secret
        $redirect_uri = 'redirect_uri_example'; // Your redirect_uri
        $code = 'code_example'; // The parameter CODE
        $refresh_token = 'refresh_token_example'; // Your refresh_token

        try {
            $result = $apiInstance->getToken($grant_type, $client_id, $client_secret, $redirect_uri, $code, $refresh_token);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling OAuth20Api->getToken: ', $e->getMessage(), PHP_EOL;
        }


        // using


        
        // $config = new Meli\Configuration();
        // $servers = $config->getHostSettings();
        // // Auth URLs Options by country

        // // 1:  "https://auth.mercadolibre.com.ar"
        // // 2:  "https://auth.mercadolivre.com.br"
        // // 3:  "https://auth.mercadolibre.com.co"
        // // 4:  "https://auth.mercadolibre.com.mx"
        // // 5:  "https://auth.mercadolibre.com.uy"
        // // 6:  "https://auth.mercadolibre.cl"
        // // 7:  "https://auth.mercadolibre.com.cr"
        // // 8:  "https://auth.mercadolibre.com.ec"
        // // 9:  "https://auth.mercadolibre.com.ve"
        // // 10: "https://auth.mercadolibre.com.pa"
        // // 11: "https://auth.mercadolibre.com.pe"
        // // 12: "https://auth.mercadolibre.com.do"
        // // 13: "https://auth.mercadolibre.com.bo"
        // // 14: "https://auth.mercadolibre.com.py"

        // // Use the correct auth URL
        // $config->setHost($servers[1]["url"]);

        // // Or Print all URLs
        // print_r($servers);

        // return
    }

    public static function olist(){

        $api_instance = new Swagger\Client\Api\DefaultApi();
        $authorization = "authorization_example"; // string | 
        $limit = "limit_example"; // string | 
        $ordering = "ordering_example"; // string | 
        $search = "search_example"; // string | 
        $offset = "offset_example"; // string | 

        try {
            $api_instance->itemsBySkuList($authorization, $limit, $ordering, $search, $offset);
        } catch (Exception $e) {
            echo 'Exception when calling DefaultApi->itemsBySkuList: ', $e->getMessage(), PHP_EOL;
        }

    }

    public static function amazon(){
                
        // Keep these safe
        $keyId = 'YOUR-AWS-KEY';
        $secretKey = 'YOUR-AWS-SECRET-KEY';
        $associateId = 'YOUR-AMAZON-ASSOCIATE-ID';

        // Setup a new instance of the AmazonUrlBuilder with your keys
        $urlBuilder = new AmazonUrlBuilder(
            $keyId,
            $secretKey,
            $associateId,
            'uk'
        );

        // Setup a new instance of the AmazonAPI and define the type of response
        $amazonAPI = new AmazonAPI($urlBuilder, 'simple');

        $items = $amazonAPI->ItemSearch('harry potter', 'Books', 'price');

        //return
    }

}
