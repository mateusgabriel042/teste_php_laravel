<!-- sample modal content -->

<div id="modal-publish" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myModalLabel">Publicar Produto -</h5>
            </div>
            <div class="modal-body">


                <form action=" {{route('products.publish')}} " method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="" required id="product_id">


                    <div class="form-group">
                        <label class="control-label mb-10">Marketplace</label>
                        <select name="company" id="company" class="form-control" required>
                            <option value="">--Selecione qualquer MarketPlace e Loja--</option>
                            @foreach ($company as $compan)
                            <optgroup label="{{ $compan->name }}">
                                @foreach ($settings as $storeApi)
                                @if($compan->name == $storeApi->company )
                                    <option value={{ $storeApi->id }}>
                                        {{ $storeApi->store }}
                                    </option>
                                @endif
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                    </div>
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
                        <label class="control-label mb-10">Tipo de anúncio</label>
                        <select class="form-control" name="listing_type_id[]" required multiple
                            data-style="form-control btn-default btn-outline">
                            <option value="">Selecione uma ou mais opções</option>
                            <option value="gold_pro">Premium</option>
                            <option value="gold_premium">Diamante</option>
                            <option value="gold_special">Clássico</option>
                            <option value="gold">Ouro</option>
                            <option value="silver">Prata</option>
                            <option value="bronze">Bronze</option>
                            <option value="free">Grátis</option>
                        </select>

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
                        </select>
                    </div>
                    {{--                <div class="form-group"> --}}
                    {{--                    <label class="control-label mb-10">tipo de entrega</label> --}}
                    {{--                    <select class="form-control" required name="shipping_type[]" --}}
                    {{--                            data-placeholder="Selecione uma opção" tabindex="1"> --}}
                    {{--                        <option value="gold_pro">Premium</option> --}}
                    {{--                        <option value="free">Grátis</option> --}}
                    {{--                    </select> --}}
                    {{--                </div> --}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-info">Publicar</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    $('#company').on('change', function () {
    $("#storeApi").attr('disabled', false); //enable subcategory select
    $("#storeApi").val("");
    $(".subcategory").attr('disabled', true); //disable all category option
    $(".subcategory").hide(); //hide all subcategory option
    $(".parent-" + $(this).val()).attr('disabled', false); //enable subcategory of selected category/parent
    $(".parent-" + $(this).val()).show();
});
</script>
