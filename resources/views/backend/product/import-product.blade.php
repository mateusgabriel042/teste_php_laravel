@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Importar Produtos</h5>
        <div class="card-body">
            <form action=" {{route('products.import.post')}} " method="post" enctype="multipart/form-data">
              @csrf
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Titulo <span class="text-danger">*</span></label>
                    <input type="file" name="file" id="" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Importar</button>
            </form>
        </div>
    </div>
@endsection
