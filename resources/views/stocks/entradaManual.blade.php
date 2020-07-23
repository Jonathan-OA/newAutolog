@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.entradaManual') 
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-body">
                            <!-- Campos para preenchimento -->
                            <div class="form_fields">
                                @include('adminlte-templates::common.errors')
                                    <!-- Alerta de erro / sucesso -->
                                @include('flash::message')
                                <div id="msg_excluir"></div>
                                {!! Form::label('pallet_barcode', Lang::get('models.pallet').':') !!}
                                {!! Form::text('pallet_barcode', null, ['class' => 'form-control']) !!}
                                {!! Form::label('barcode', Lang::get('models.barcode').':') !!}
                                {!! Form::text('barcode', null, ['class' => 'form-control']) !!}
                                {!! Form::open(['route' => 'stocks.store', 'id' => 'entForm']) !!} 
                                <!-- Só mostra demais campos quando ler um barcode correto --> 
                                <div id="hidden" class="hidden">    
                                    <div class="form-group">
                                        {!! Form::label('product_code', Lang::get('models.product_code').':') !!}
                                        {!! Form::text('product_code', null, ['class' => 'form-control', 'readonly']) !!}
                                        <div class="col-md-6">
                                            {!! Form::label('qty', Lang::get('models.qty').':') !!}
                                            {!! Form::text('qty', null, ['class' => 'form-control']) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::label('uom_code', Lang::get('models.uom_code').':') !!}
                                            {!! Form::text('uom_code', null, ['class' => 'form-control', 'readonly']) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::label('prim_qty', Lang::get('models.prim_qty').':') !!}
                                            {!! Form::text('prim_qty', null, ['class' => 'form-control']) !!}    
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::label('prim_uom_code', Lang::get('models.prev_uom_code').':') !!}
                                            {!! Form::text('prim_uom_code', null, ['class' => 'form-control', 'readonly']) !!}
                                        </div>
                                            {!! Form::label('location_code', Lang::get('models.location_code').':') !!}
                                            {!! Form::text('location_code', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'locations']) !!}
                                            <!-- Campos não visiveis para o usuario -->
                                            {{ Form::hidden('company_id', Auth::user()->company_id) }}
                                            {{ Form::hidden('user_id', Auth::user()->id) }}
                                            {{ Form::hidden('label_id', '', array('id' => 'label_id')) }}
                                            {{ Form::hidden('task_id', '') }}
                                            {{ Form::hidden('pltbarcode', '', array('id' => 'pltbarcode')) }}
                                            {{ Form::hidden('pallet_id', '', array('id' => 'pallet_id')) }}
                                            {{ Form::hidden('finality_code', 'SALDO') }}
                                            {{ Form::hidden('operation_code', 'stocks_add') }}
                                    </div>  
                                </div> 
                            </div>
                            {!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('stocks.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
                            {!! Form::close() !!}
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
        $("#pallet_barcode").bind('keypress change',function(e){
            
             //Se apertar enter ou alterar o campo entra na função
            if(e.which == 13 || e.type == 'change') {
                //Valida palete informado (Se não existir vai criar)
                var cbplt = $(this).val();
                if(cbplt || !$(this).hasClass('input_error') || !$(this).hasClass('input_ok')){
                    $.ajax("pallets/val/"+ cbplt)
                    .done(function(data) {
                        //erro = 1: Não existe; erro = 2: status encerrado ou cancelado
                        if(data.erro == 1 && cbplt != 0){
                            $("#pallet_id").val("");
                            if(confirm("Palete não existe. Deseja criar um novo?")){
                                $("#pallet_barcode").removeClass('input_error');
                                $("#pallet_barcode").addClass('input_ok is-valid');
                                $("#pallet_id").val(data.id);
                                $("#barcode").focus();
                            }else{
                                $("#pallet_barcode").addClass('input_error');
                                $("#pallet_barcode").val("");
                            }
                            $('#msg_excluir').html("");
                        }else{
                            if(data.erro == 3){
                                $('#msg_excluir').html("<div class='alert alert-danger'>@lang('validation.plt_prefixo')</div>");
                                $("#pallet_barcode").addClass('input_error');
                            }else{
                                $('#msg_excluir').html("");
                                $("#pallet_barcode").removeClass('input_error');
                                $("#pallet_barcode").addClass('input_ok');
                                $("#pallet_id").val(data.id);
                                $("#barcode").focus();
                            }
                        }
                        $("#pltbarcode").val(cbplt);
                    })
                }
            }

        });

        $("#barcode").bind('keypress change',function(e){
            //Se apertar enter ou alterar o campo, busca informações do barcode informado
            if(e.which == 13 || e.type == 'change')  {
                $.ajax("products/val/"+ $(this).val())
                .done(function(data) {
                    if(data.erro == 0){
                        //Caso encontre o barcode, atualiza os inputs com os valores obtidos
                        $("#qty").val(data.infos.qty);
                        $("#prev_qty").val(data.infos.prev_qty);
                        $("#uom_code").val(data.infos.uom_code);
                        $("#prim_uom_code").val(data.infos.prim_uom_code);
                        $("#product_code").val(data.infos.product_code);
                        $("#label_id").val(data.infos.label_id);
                        //Limpa campo de msg, caso esteja preenchido
                        $('#msg_excluir').html("");
                        $('#hidden').removeClass('hidden');
                        $('.alert').remove();
                        
                    }else{
                        //Mostra msg de barcode invalido ou validade
                        $('#msg_excluir').html("<div class='alert alert-danger'>"+data.msg_erro+"</div>");
                        $("#barcode").val("");
                        $("#location_code").val("");
                        $('#hidden').addClass('hidden');
                    }
                })

            }
        })
    });

</script>
@endsection