<?php

namespace App\Http\Controllers;

use App\Models\Api;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function store(Request $request)
    {
        $settings = new  Api();
        $settings->store = $request->get('store');
        $settings->company = $request->get('company');
        $settings->app_id = $request->get('app_id');
        $settings->secret_key = $request->get('secret_key');
        $settings->access_key = $request->get('access_key');
        $settings->url_redirect = $request->get('url_redirect');
        $settings->mode = $request->get('mode');
        if ($settings->save()) {
            $data = Api::verifyCompany($settings);
            return new RedirectResponse($data);
//            return redirect()->away($data);
//            return redirect()->route('settings.api.index')->with('success', 'Configuração de Api registrada com sucesso!');
        }


    }


    public function destroy($id)
    {
        $settings = Api::query()->findOrFail($id);
        $settings->delete();
    }



    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

   


    public function casasbahia(){

        return view('frontend.pages.api.casasbahia');

    }
    public function mercadolibrarie(){

        return view('frontend.pages.api.mercadolivre');

    }

    public function amazon(){

        return view('frontend.pages.api.amazon');

    }
    public function magalu(){

        return view('frontend.pages.api.magalu');

    }
    public function olist(){

        return view('frontend.pages.api.olist');

    }
    public function shopee(){

        return view('frontend.pages.api.shopee');

    }
    public function americanas(){

        return view('frontend.pages.api.americanas');

    }
    
   
}
