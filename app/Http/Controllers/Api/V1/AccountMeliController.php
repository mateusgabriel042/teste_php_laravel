<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\Api;
use Illuminate\Http\Request;
use App\Services\MercadoLivreService;
use Illuminate\Http\Response;
use App\Http\Requests\AccountMeliRequest;

class AccountMeliController extends Controller
{

    public function index()
    {
        $api = Api::where('user_id', auth()->user()->id)->get();
        if (!$api) {
            return view('backend.account.index')->with('account',[]);
        }
        return view('backend.account.index')->with('account',$api);
    }

    public function create()
    {
        return view('backend.account.create');
    }

    public function store(AccountMeliRequest $request)
    {
        $input = $request->only(['name','url','store','company','app_id','access_key','access_token','refresh_token','secret_key','url_redirect','mode']);
        $input['user_id'] = auth()->user()->id;
        $input['status'] = 'inactive';
        $status = Api::create($input);
        if($status){
            request()->session()->flash('success','Account Successfully created');
        }
        else{
            request()->session()->flash('error','Something went wrong! Please try again!!');
        }
        return redirect()->route('multiuser.index');
    }

    public function edit($id)
    {
        $api = Api::where('id', $id)->where('user_id', auth()->user()->id)->first();
        return view('backend.account.edit')->with('api', $api);
    }

    public function update(AccountMeliRequest $request, $id)
    {
        $api = Api::where('user_id', auth()->user()->id)->where('id', $id);
        $input = $request->only(['name','url','store','company','app_id','access_key','access_token','refresh_token','secret_key','url_redirect','mode']);
        if($api){
            $status = $api->update($input);
            if($status){
                request()->session()->flash('success','Account Successfully updated');
            }
            else{
                request()->session()->flash('error','Something went wrong! Please try again!!');
            }
        }
        else{
            request()->session()->flash('error','Account not found!!');
        }

        return redirect()->route('multiuser.index');
    }

    public function destroy($id)
    {
        $api = Api::where('user_id', auth()->user()->id)->where('id', $id);
        $status = $api->delete();
        if($status){
            request()->session()->flash('success','Account Successfully deleted');
        }
        else{
            request()->session()->flash('error','Something went wrong! Please try again!!');
        }
        return redirect()->route('multiuser.index');
    }

    public function alterAccount($id)
    {
        $api = Api::where('user_id', auth()->user()->id)->where('id', $id)->get();
        
        $this->inactiveStatus();
        $status = $this->activeStatus($id);
        
        Cache::put('user_system_id', $id);

        $meli = new MercadoLivreService();
        $response = $meli->refreshToken();

        if($status){
            request()->session()->flash('success','Account successfully activated');
        }
        else{
            request()->session()->flash('error','Something went wrong! Please try again!!');
        }
    
        return redirect()->route('multiuser.index');
    }
    
    public function inactiveStatus()
    {
        $status = Api::where('user_id', auth()->user()->id);
        $status->update(['status'=>'inactive']);
        return $status;
    }

    public function activeStatus($id)
    {
        $status = Api::where('user_id', auth()->user()->id)->where('id', $id);
        $status->update(['status'=>'active']);
        return $status;
    }
}