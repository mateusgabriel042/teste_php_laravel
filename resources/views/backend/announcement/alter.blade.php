@extends('backend.layouts.master')

@section('main-content')
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row">
        <div class="col-md-12">
          <h6 class="m-0 font-weight-bold text-primary float-left">Filtros</h6>
        </div>
        <div class="col-md-12">
          <form method="get" action="{{route('announcement.alter')}}">
            <div class="row">
              <div class="col-md-12 mt-3">
                <div class="form-group">
                  <label for="id_api">Conta <span class="text-danger">*</span></label>
                  <select name="id_api" id="id_api" class="form-control" required>
                      <option value="">--Selecione qualquer Conta--</option>
                      @foreach($accounts as $account)
                          <option
                            value='{{$account->id}}' 
                            {{ app('request')->input('id_api') == $account->id || session('id_api') == $account->id ? 'selected' : '' }}
                          >
                            {{$account->store}}
                          </option>
                      @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-sm float-right mr-1">Buscar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow mb-4">
      <div class="row">
          <div class="col-md-12">
              @include('backend.layouts.notification')
          </div>
      </div>
      <div class="card-header py-3">
        <div class="card-header-actions">
            <h6 class="m-0 font-weight-bold text-primary float-left">Product Lists</h6>
            <div>
                <a href="{{ url('admin/announcement/edit-multiple/') }}" class="btn btn-primary btn-sm float-left mr-1" id="link-edit-multiple">
                    Alterar selecionados
                </a>
            </div>
        </div>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              @if (count($products) > 0)
                  <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>S.N.</th>
                              <th>Title</th>
                              <th>Category</th>
                              <th>Price</th>                 
                              <th>Condition</th>
                              <th>Stock</th>
                              <th>Photo</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                              <th>#</th>
                              <th>S.N.</th>
                              <th>Titulo</th>
                              <th>Categoria</th>
                              <th>Preço</th>
                              <th>Condição</th>
                              <th>Estoque</th>
                              <th>Foto</th>
                              <th>Status</th>
                              <th>Ações</th>
                          </tr>
                      </tfoot>
                      <tbody>

                          @foreach ($products as $product)
                              <tr>
                                  <td><input type="checkbox" class="input_select_id" value="{{$product->id}}"></td>
                                  <td>{{ $product->id }}</td>
                                  <td>{{ $product->title ?? __('') }}</td>
                                  <td>{{ $product->cat_info['title'] ?? __('') }}
                                      <sub>
                                          {{ $product->cat_ml_id ?? '' }}
                                      </sub>
                                  </td>
                                  
                                  <td>Rs. {{ $product->price }} /-</td>
                                  
                                  
                                  <td>{{ $product->condition }}</td>
                                  {{-- <td> {{ ucfirst($product->brand->title) }}</td> --}}
                                  <td>
                                      @if ($product->stock > 0)
                                          <span class="badge badge-primary">{{ $product->stock }}</span>
                                      @else
                                          <span class="badge badge-danger">{{ $product->stock }}</span>
                                      @endif
                                  </td>
                                  <td>
                                      @if ($product->photo)
                                          @php
                                              $photo = explode(',', $product->photo);
                                              // dd($photo);
                                          @endphp
                                          <img src="{{ $photo[0] }}" class="img-fluid zoom" style="max-width:80px"
                                              alt="{{ $product->photo }}">
                                      @else
                                          <img src="{{ asset('backend/img/thumbnail-default.jpg') }}" class="img-fluid"
                                              style="max-width:80px" alt="avatar.png">
                                      @endif
                                  </td>
                                  <td>
                                      @if ($product->status == 'active')
                                          <span class="badge badge-success">{{ $product->status }}</span>
                                      @else
                                          <span class="badge badge-warning">{{ $product->status }}</span>
                                      @endif
                                  </td>
                                  <td>
                                      <a href=" {{route('announcement.edit2',['id' => $product->id, 'id_api' => app('request')->input('id_api')])}} "
                                          class="btn btn-primary btn-sm float-left mr-1">
                                      <i class="fas fa-edit"></i> Alterar Anúncio</a>
                                  </td>
                              </tr>
                          @endforeach
                      </tbody>
                  </table>

                  <ul class="pagination justify-content-center mt-4">
                      <nav aria-label="Page navigation example">
                          <ul class="pagination">

                              @if (!is_null($products->previousPageUrl()))
                                  <li class="page-item"><a class="page-link"
                                          href=" {{ $products->previousPageUrl() }} ">Previous</a>
                                  </li>
                              @endif
                              @if (!is_null($products->nextPageUrl()))
                                  <li class="page-item">
                                      <a class="page-link" href=" {{ $products->nextPageUrl() }} ">Next</a>
                                  </li>
                              @endif

                          </ul>
                      </nav>
                  </ul>
              @else
                  <h6 class="text-center">Nenhum produto encontrado! Por favor, filtre por uma conta ou crie um produto</h6>
              @endif
          </div>
      </div>
  </div>
@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

        .zoom {
            transition: transform .2s;
            /* Animation */
        }

        .zoom:hover {
            transform: scale(5);
        }
        .card-header-actions {float:left; width:100%; display:flex; align-items:center; align-content: center; justify-content:space-between;}
        #link-edit-multiple {display:none;}
    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script>
        $('#product-dataTable').DataTable({
            "scrollX": false, 
            "columnDefs": [{
                "orderable": false,
                "targets": [10, 11, 12]
            }]
        });

        // Sweet alert

        function deleteData(id) {

        }
    </script>
    <script>
        function shareProuct() {
            $("#modal-publish").modal('show')
        }
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                        title: "Tem certeza?",
                        text: "Uma vez excluído, você não poderá recuperar esses dados!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Seus dados estão seguros!");
                        }
                    });
            })
        })
    </script>

    <script>
        let checkboxesElements = document.querySelectorAll('.input_select_id');
        let checkboxesArray = Array.from(checkboxesElements);
        let elementLinkIdsSelected = document.querySelector('#link-edit-multiple');
        let elementInputIdApi = document.querySelector('#id_api');
        
        const baseLink = elementLinkIdsSelected.href;
        
        let idsSelected = [];
        checkboxesArray.forEach(function(element) {
            element.addEventListener('change', function() {
                if (element.checked)
                    idsSelected.push(element.value)
                else
                    idsSelected = idsSelected.filter(id => id != element.value);
                if(idsSelected.length == 0)
                    elementLinkIdsSelected.style.display = 'none';
                else
                    elementLinkIdsSelected.style.display = 'block';

                elementLinkIdsSelected.href = `${baseLink}/${idsSelected.join(',')}/${elementInputIdApi.value}`;
            }); 
        });
        
    </script>
@endpush