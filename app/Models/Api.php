<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    protected $table = 'apis';
    protected $fillable = ['name', 'user_id', 'url', 'store', 'company', 'app_id', 'access_key', 'access_token', 'refresh_token', 'secret_key', 'url_redirect', 'status', 'mode'];

    static function verifyCompany($company)
    {
        switch ($company->company) {
            case 'Mercado Livre':
                return "https://auth.mercadolivre.com.br/authorization?response_type=code&client_id={$company->app_id}&redirect_uri={$company->url_redirect}";
            default:
               return null;
        }
    }
}
