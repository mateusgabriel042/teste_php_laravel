@extends('backend.layouts.master')

@section('main-content')
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row">
        <div class="col-md-12">
          <h6 class="m-0 font-weight-bold text-primary float-left">Financeiro -> Relatório</h6>
        </div>
        <div class="col-md-12">
          <form method="get" action="{{route('financial.report')}}">
            <div class="row">
              <div class="col-md-12 mt-3">
                <div class="form-group">
                  <label for="id_api">Conta <span class="text-danger">*</span></label>
                  <select name="id_api" id="id_api" class="form-control" required>
                      <option value="">--Selecione qualquer Conta--</option>
                      @foreach($accounts as $account)
                          <option
                            value='{{$account->id}}' 
                            {{ app('request')->input('id_api') == $account->id ? 'selected' : '' }}
                          >
                            {{$account->store}}
                          </option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-sm float-right mr-1">Exportar Relatório</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
