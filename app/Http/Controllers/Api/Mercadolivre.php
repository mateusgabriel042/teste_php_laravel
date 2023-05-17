<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\User;

// use Shopee\Client;

require __DIR__.'/../../../../vendor/autoload.php';

use Dsc\MercadoLivre\Meli;
use Dsc\MercadoLivre\Resources\Authorization\AuthorizationService;
use Dsc\MercadoLivre\Requests\Category\CategoryService;
use Dsc\MercadoLivre\Environments\Site;
use Dsc\MercadoLivre\Requests\Currency\CurrencyService;
use Dsc\MercadoLivre\Resources\User\UserService;
use Dsc\MercadoLivre\Resources\Order\OrderService;

class Mercadolivre
{

    public static function api_connect() {

        $meli = new Meli('627411294104034', 'sLzXj7NJzyycKFpAYBu2vGw0vlg7QewN');
        $service = new AuthorizationService($meli);

        $token = $service->getAccessToken();

        return $token;
    }

    public static function api(){
                
        session_start();

        $acess = $_SESSION["token"];

        if(empty($acess)){

            $meli = new Meli('627411294104034', 'sLzXj7NJzyycKFpAYBu2vGw0vlg7QewN');
            $service = new AuthorizationService($meli);

            $token = $service->getAccessToken();

            $_SESSION["token"] = $token;
            
        }else{
            $_SESSION["token"] = $acess;
        }

        echo $acess;

        
        // $cate = new CategoryService();

        // $cate->findCategories(Site::BRASIL);

        // // $category = $cate->findCategory('MLA5725');

        // echo json_encode($cate);



        ////....
        

        $service = new UserService($meli);

        // Consulta dados do usuário
        $information = $service->getInformationAuthenticatedUser();


        /////.....

        // Consulta uma moeda específica
        // $currency = $service->findCurrency('ARS');

        // Consulta a lista de moedas e seus atributos
        // $currencies = $service->findCurrencies();

        ////.....


        
        // fopen(__DIR__ .'/../../../../api/mercadolibre/lib/Api/OAuth20Api.php', "r");

    }


    public static function api_pefil(){


        $meli = new Meli('627411294104034', 'sLzXj7NJzyycKFpAYBu2vGw0vlg7QewN');
        $service = new AuthorizationService($meli);

        $token = $service->getAccessToken();

        $service = new UserService($meli);

        $information = $service->getInformationAuthenticatedUser();

        print_r($information);

     
       
        // for ($i=0; $i < count($information); $i++) { 
        //    echo $information[i];
        // }


        
    }


    
    public static function api_pedidos(){

        $meli = new Meli('627411294104034', 'sLzXj7NJzyycKFpAYBu2vGw0vlg7QewN');
        $ser = new AuthorizationService($meli);

        $token = $ser->getAccessToken();

        $service = new OrderService($meli);
        // Consulta de pedidos de um vendedor
        // $orders = $service->findOrdersBySeller('SELLER-ID');
        // Ou Consulta de pedidos de um comprador
        // $orders = $service->findOrdersByBuyer('1');

        // Nesses métodos você tem a opção de passar alguns parâmetros adicionais
        // para paginação ou ordenação
        $limit = 50;
        $offset = 0;
        $sort = 'date_desc';
        $orders = $service->findOrdersBySeller('5', $limit, $offset, $sort);



        // dd($orders);

        /////////////// MLB3
     
       
        // for ($i=0; $i < count($information); $i++) { 
        //    echo $information[i];
        // }


        
    }



    public static function api2(){
                
        session_start();

        $acess = $_SESSION["token"];

        $meli = new Meli('627411294104034', 'sLzXj7NJzyycKFpAYBu2vGw0vlg7QewN');
        $auth = new AuthorizationService($meli);

        if(empty($acess)){


            $token = $auth->getAccessToken();        
            $_SESSION["token"] = $token;
            
        }else{
            $_SESSION["token"] = $acess;
        }


        $service = new UserService($meli);

        // Consulta dados do usuário
        $information = $service->getInformationAuthenticatedUser();
        
        
        // $cate = new CategoryService();

        // $category = $cate->findCategories(Site::BRASIL);

        // // $category = $cate->findCategory('MLA5725');

        // echo json_encode($category);

        ///....




        dd($information);

        // $apiInstance = new Meli\Api\OAuth20Api(
        //     new GuzzleHttp\Client()
        // );
        // $grant_type = 'authorization_code';
        // $client_id = '627411294104034'; // Your client_id
        // $client_secret = 'sLzXj7NJzyycKFpAYBu2vGw0vlg7QewN'; // Your client_secret
        // $redirect_uri = 'http://localhost:8080/admin'; // Your redirect_uri
        // $code = 'code_example'; // The parameter CODE
        // $refresh_token = 'refresh_token_example'; // Your refresh_token

        // try {
        //     $result = $apiInstance->getToken($grant_type, $client_id, $client_secret, $redirect_uri, $code, $refresh_token);
        //     print_r($result);
        // } catch (Exception $e) {
        //     echo 'Exception when calling OAuth20Api->getToken: ', $e->getMessage(), PHP_EOL;
        // }

        // echo ''

        
        // fopen(__DIR__ .'/../../../../api/mercadolibre/lib/Api/OAuth20Api.php', "r");

    }


    public function api2_anuncio(){
        $meli = new Meli('APP-ID', 'SECRET-ID');

            $item = new Item();
            $item->setTitle('Test item - no offer')
                ->setCategoryId('MLB46585')
                ->setPrice(100)
                ->setCurrencyId('BRL')
                ->setAvailableQuantity(10)
                ->setBuyingMode('buy_it_now')
                ->setListingTypeId('gold_especial')
                ->setCondition('new')
                ->setDescription('Test item - no offer')
                ->setWarranty('12 months');

            // Imagem do Produto        
            $picture = new Picture();
            $picture->setSource('http://mla-s2-p.mlstatic.com/968521-MLA20805195516_072016-O.jpg');
            $item->addPicture($picture); // collection de imagens

            $announcement = new Announcement($meli);
            $response = $announcement->create($item);

            // Link do produto publicado
            echo $response->getPermalink();
    }
   
}
?>


