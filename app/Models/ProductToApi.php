<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductToApi extends Model
{
    //
    protected $fillable = [
        'checked',
        'id_pulish_ml',
        'id_products',
        'id_api',
        'link_api_publish_product'
    ];
}
