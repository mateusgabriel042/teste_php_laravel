@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Importar Produto</h5>
    <div class="card-body">
      <form method="post" enctype="multipart/form-data" action="{{route('product.import.post')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="cat_id">Fornecedor <span class="text-danger">*</span></label>
          <select name="id_provider" id="id_provider" class="form-control" required>
              <option value="">--Selecione qualquer Fornecedor--</option>
              @foreach($providers as $cat_data)
                  <option value='{{$cat_data->id}}'>{{$cat_data->name}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="file" class="col-form-label">Escolher arquivo <span class="text-danger">*</span></label>
          <input type="file" name="file" id="file" class="form-control">
          {{-- @if($message)
            <span class="text-info">{{$message}}</span>
          @endif --}}
        </div>
        <div class="form-group">
            <label for="quantity">Quantidade Máxima <span class="text-danger">*</span></label>
            <select name="quantity" id="quantity" class="form-control" required>
                <option value="">--Selecione a quantidade máxima--</option>
                    <option value="20">20</option>
                    <option value="20">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="500">500</option>
                    <option value="1000">1000</option>
                    <option value="1500">1500</option>
                    <option value="2000">2000</option>
                    <option value="2000">4000</option>
                    <option value="2000">5000</option>
                    <option value="2000">10000</option>
            </select>
        </div>

        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Resetar</button>
           <button class="btn btn-success" type="submit">Importar</button>
        </div>

      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@endpush
