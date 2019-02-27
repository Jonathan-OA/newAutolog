@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.stock_transfer') 
                </div>
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-body">
                                <!-- Campos para preenchimento -->
                                <div class="form_fields">
                                    @include('adminlte-templates::common.errors')
                                     <!-- Alerta de erro / sucesso -->
                                    @include('flash::message')
                                    <div id="msg_excluir"></div>
                                    <div class="col-md-4">
                                        {!! Form::label('barcode_orig', Lang::get('models.barcode_orig').':') !!}
                                        {!! Form::text('barcode_orig', null, ['class' => 'form-control', 'id' => 'barcode_orig']) !!}
                                    </div>
                                    <div class="col-md-3">
                                        <span id="orig_location" class="hidden">
                                            {!! Form::label('orig_location_code', Lang::get('models.orig_location_code').':') !!}
                                            {!! Form::text('orig_location_code', null, ['class' => 'form-control','readonly']) !!}
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <span id="label_barcodeD" class="hidden">
                                                {!! Form::label('label_barcode', Lang::get('models.label_barcode').':') !!}
                                                {!! Form::text('label_barcode', null, ['class' => 'form-control']) !!}
                                        </span>
                                    </div>
                                    <div class="col-md-1">
                                        <a class="btn btn-success"  href="#" onclick="addItem()">Add</a>
                                    </div>  
                                    {{ Form::hidden('pallet_id', '', array('id' => 'pallet_id')) }}
                                    {{ Form::hidden('pltbarcode', '', array('id' => 'pltbarcode')) }}
                                    {{ Form::hidden('prev_qty', '', array('id' => 'prev_qty')) }}
                                    {{ Form::hidden('prev_uom_code', '', array('id' => 'prev_uom_code')) }}
                                    {{ Form::hidden('product_code', '', array('id' => 'product_code')) }}

                                    <!-- Tabela que lista as etiquetas lidas para esta transferência -->
                                    {!! Form::open(['route' => 'transfer.storeStockTransfer', 'id' => 'trfForm']) !!} 
                                    <div class="col-md-10 col-md-offset-1" style="margin-top: 3vh">
                                        <table class="table table-bordered table-din" id="transfer-table" cellspacing="0" width="100%">
                                                <thead>
                                                    <th class="th_grid">@lang('models.pallet_id') </th>
                                                    <th class="th_grid">@lang('models.label_id') </th>
                                                    <th class="th_grid">@lang('models.product_code') </th>
                                                    <th class="th_grid">@lang('models.location_code') </th>
                                                    <th class="th_grid">@lang('models.qty') </th>
                                                    <th class="th_grid">@lang('models.action') </th>
                                                </thead>
                                                <tbody >
                                                </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        {!! Form::label('dest_location_code', Lang::get('models.dest_location_code').':') !!}
                                        {!! Form::text('dest_location_code', null, ['class' => 'form-control']) !!}
                                    </div>
                                    
                                </div>
                                
                                
                                {!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
                                <a href="{!! route('transfer.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(function() {
        //Campo PALETE/ETIQUETA origem
        $("#barcode_orig").bind('change',function(e){
             //Se apertar enter ou alterar o campo entra na função
            if(e.type == 'change' ) {
                e.preventDefault();
                var prefixos = "{{$prefixos}}";
                var arrayPref = prefixos.split(',');               
                //Valida palete ou etiqueta informado
                var cbplt = $(this).val();
                if(jQuery.inArray(cbplt.substr(0,3), arrayPref) != -1){
                    //Se tem prefixo de palete, Procura palete
                    $.ajax("pallets/val/"+ cbplt)
                    .done(function(data) {
                        //erro <> 5 = Palte não encontrado ou não possui saldo
                        if(data.erro != 5 && cbplt != 0){
                            //Erro
                            $('#msg_excluir').html("<div class='alert alert-danger'>"+data.msg_erro+"</div>");
                            //Esconde campos de endereço e etiqueta para ler novamente e da msg de erro
                            $("#barcode_orig").addClass('input_error');
                            $('#orig_location').addClass('hidden');
                            $('#label_barcodeD').addClass('hidden');
                            $("#pallet_id").val('');
                        }else{
                            $('#msg_excluir').html("");
                            $("#barcode_orig").removeClass('input_error');
                            $("#barcode_orig").addClass('input_ok');
                            $("#pallet_id").val(data.id);
                            $('#orig_location').removeClass('hidden');
                            $('#label_barcodeD').removeClass('hidden');
                            $("#orig_location_code").val(data.location);
                            $("#barcode").focus();
                            //Bloqueia o input de endereço caso seja palete
                            $('#orig_location_code').attr('readonly', true)
                            $("#pltbarcode").val(cbplt);
                        }
                        
                    })
                }else{
                    //Não é palete, Procura Etiqueta
                    $.ajax("products/val/"+ cbplt)
                    .done(function(dataL) {
                        //console.log(dataL);
                        if(dataL.erro == 0){
                            //Caso encontre o barcode, atualiza os inputs com os valores obtidos
                            //Limpa campo de msg, caso esteja preenchido
                            $('#msg_excluir').html("");
                            $("#prev_qty").val(dataL.infos.prev_qty);
                            $("#product_code").val(dataL.infos.product_code);
                            $('.alert').remove();
                            $("#pltbarcode").val("");
                            $("#pallet_id").val("");
                            if(dataL.infos.label_id != ""){
                                $("#label_barcode").val(cbplt);
                            }
                            $('#orig_location').removeClass('hidden');
                            $('#orig_location_code').removeAttr('readonly');
                            $('#orig_location_code').val('');
                            $('#label_barcodeD').addClass('hidden');
                        }else{
                            //Não encontrou o barcode ou etiqueta vencida
                            $('#msg_excluir').html("<div class='alert alert-danger'>"+dataL.msg_erro+"</div>");
                        }
                    })
                }
            }

        });

        //Campo ETIQUETA 
        $("#label_barcode").bind('change',function(e){
            var pallet_id = $("#pallet_id").val();
            var cbplt = $(this).val();
            //Se apertar enter ou alterar o campo entra na função
            if(e.type == 'change') {
                if(cbplt.length > 0){
                    //Se preencheu algo, busca etiqueta
                    $.ajax("products/val/"+ cbplt)
                    .done(function(dataL) {
                        if(dataL.erro == 0){
                            //Caso encontre o barcode, atualiza os inputs com os valores obtidos
                            //Limpa campo de msg, caso esteja preenchido
                            $('#msg_excluir').html("");
                            $("#prev_qty").val(dataL.infos.prev_qty);
                            $("#product_code").val(dataL.infos.product_code);
                            $('.alert').remove();
                            $("#label_barcode").removeClass('input_error');
                            $("#label_barcode").addClass('input_ok');
                        }else{
                            $("#label_barcode").removeClass('input_ok');
                            $("#label_barcode").addClass('input_error');
                            //Mostra msg de barcode invalido ou validade
                            $('#msg_excluir').html("<div class='alert alert-danger'>@lang('validation.cb_error')</div>");
                        }
                    })
                }else{
                    //Campo vazio, limpa erros
                    $('#msg_excluir').html("");
                    $('.alert').remove();
                    $("#label_barcode").removeClass('input_error');
                    $("#label_barcode").removeClass('input_ok');
                }
            }
        })

        //Apaga item da lista
        $('#transfer-table tbody').on( 'click', 'button', function () {
            var data = $(this).parents('tr');
            data.remove();
        })

    });

    //Adiciona item para transferência
    function addItem(){
        var pallet_id = $("#pallet_id").val();
        var pallet = $("#pltbarcode").val();
        var label = $("#label_barcode").val();
        var location = $("#orig_location_code").val();
        var qtde = $("#prev_qty").val();
        var product = $("#product_code").val();

        //Se leu o pallet inteiro e não informou etiqueta, transfere o pallet inteiro
        if(pallet.length > 0 && label.length === 0){
            $.ajax("pallets/items/"+ pallet_id)
            .done(function(datat) {
                datat.forEach(function(item) {
                    $("#transfer-table")
                    .append("<tr id='"+item.id+"'><td>"+item.plt_barcode+"</td><td><input name='labels[]' type='text' value='"+item.label_barcode+"' readonly></td><td>"
                            +item.product_code+"</td><td>"+location+"</td><td><input name='qtys[]' type='number' 'step'='0.000001' value='"+item.prev_qty+"'>"+item.prev_uom_code+
                            "</td><td align='center'><button id='remove' aria-label='@lang('buttons.remove')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='{{asset('/icons/remover.png')}}'></button></td></tr>")
                });
            }); 
        }else{
            //Insere só o produto lido caso ainda não exista
            if($('input[type=text]').each(function(){
                arrText.push($(this).val());
            }))
            $("#transfer-table")
            .append("<tr><td>"+pallet+"</td><td><input name='labels[]' type='text' value='"+label+"' readonly></td><td>"
                            +product+"</td><td>"+location+"</td><td><input name='qtys[]' type='number' 'step'='0.000001' value='"+qtde+"'>"+item.prev_uom_code+
                            "</td><td align='center'><button id='remove' aria-label='@lang('buttons.remove')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='{{asset('/icons/remover.png')}}'></button></td></tr>")
            }
    }

    

</script>
@endsection