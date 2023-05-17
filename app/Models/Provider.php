<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    //
    protected $fillable=['name', 'site', 'email', 'phone'];

    public function getAll(){
        $teste = Provider::all();
        dd($teste);
    }

    public function getOne($id){
        $teste = Provider::find($id);
        dd($teste);
    }

    public function importALot(Request $request){

    }

    public function createOne(Request $request){
        
        $provider = [
            'name' => 'Outro Site',
            'site' => 'wwww.outrosite.com.br',
            'email' => 'vendas@outrosite.com.br',
            'phone' => '+5598981055665',
        ];

        $teste = Provider::create($provider);
        dd($teste);
    }

    public function updateOne(Request $request){

    }

    public function deleteOne(Request $request){

    }
}
