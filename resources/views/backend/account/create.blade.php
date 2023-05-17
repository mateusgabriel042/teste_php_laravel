@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Adicionar Api Mercado Livre</h5>
    <div class="card-body">
      <form method="post" action="{{route('multiuser.store')}}">
        {{csrf_field()}}
        <div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label for="name" class="col-form-label">Name</label>
            <input id="name" type="text" name="name" placeholder="Enter name" class="form-control">
            @error('name')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label for="url" class="col-form-label">URL</label>
            <input id="url" type="text" name="url" placeholder="Enter url" class="form-control">
            @error('url')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label for="store" class="col-form-label">Store</label>
            <input id="store" type="text" name="store" placeholder="Enter store" class="form-control">
            @error('store')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label for="company" class="col-form-label">Company</label>
            <input id="company" type="text" name="company" placeholder="Enter company" class="form-control">
            @error('company')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label for="app_id" class="col-form-label">APP ID</label>
            <input id="app_id" type="text" name="app_id" placeholder="Enter app_id" class="form-control">
            @error('app_id')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label for="access_key" class="col-form-label">Access Key</label>
            <input id="access_key" type="text" name="access_key" placeholder="Enter access_key" class="form-control">
            @error('access_key')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label for="access_token" class="col-form-label">Access Token</label>
            <input id="access_token" type="text" name="access_token" placeholder="Enter access_token" class="form-control">
            @error('access_token')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label for="refresh_token" class="col-form-label">Refresh Token</label>
            <input id="refresh_token" type="text" name="refresh_token" placeholder="Enter refresh_token" class="form-control">
            @error('refresh_token')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label for="secret_key" class="col-form-label">Secret Key</label>
            <input id="secret_key" type="text" name="secret_key" placeholder="Enter secret_key" class="form-control">
            @error('secret_key')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label for="url_redirect" class="col-form-label">URL Redirect</label>
            <input id="url_redirect" type="text" name="url_redirect" placeholder="Enter url_redirect" class="form-control">
            @error('url_redirect')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="form-group row">
          <div class="col-sm-6 mb-3 mb-sm-0">
            <label for="mode" class="col-form-label">Mode</label>
            <select name="mode" class="form-control">
              <option value="test">Test</option>
              <option value="prod">Prod</option>
            </select>
            @error('mode')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>
        <div class="form-group mb-3">
          <a href="{{route('multiuser.index')}}" class="btn btn-primary">Voltar</a>
          <button type="reset" class="btn btn-warning">Resetar</button>
          <button class="btn btn-success" type="submit">Enviar</button>
        </div>
      </form>
    </div>
</div>

@endsection
