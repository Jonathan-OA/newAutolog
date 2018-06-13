@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.entradaManual') 
                </div>
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Alerta de erro / sucesso -->
                            @include('flash::message')
                            <div id="msg_excluir"></div>
                            <div class="panel-body">
                                {!! Form::open(['route' => 'stocks.store']) !!}  
                                    <!-- Campos para preenchimento -->
                                    {!! Form::label('barcode', Lang::get('models.barcode').':') !!}
                                    {!! Form::text('barcode', null, ['class' => 'form-control']) !!}
                                    <div >
                                        {!! Form::label('product_code', Lang::get('models.product_code').':') !!}
                                        {!! Form::text('product_code', null, ['class' => 'form-control', 'readonly']) !!}
                                        {!! Form::label('qty', Lang::get('models.qty').':') !!}
                                        {!! Form::text('qty', null, ['class' => 'form-control']) !!}
                                        {!! Form::label('uom_code', Lang::get('models.uom_code').':') !!}
                                        {!! Form::text('uom_code', null, ['class' => 'form-control', 'readonly']) !!}
                                        {!! Form::label('prev_qty', Lang::get('models.prev_qty').':') !!}
                                        {!! Form::text('prev_qty', null, ['class' => 'form-control']) !!}    
                                        {!! Form::label('prev_uom_code', Lang::get('models.prev_uom_code').':') !!}
                                        {!! Form::text('prev_uom_code', null, ['class' => 'form-control', 'readonly']) !!}
                                        {!! Form::label('location_code', Lang::get('models.location_code').':') !!}
                                        {!! Form::text('location_code', null, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'locations']) !!}

                                        <!-- Campos não visiveis para o usuario -->
                                        <input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>
                                        <input id='label_id' name='label_id' type='hidden' value='0'>
                                        <input id='pallet_id' name='pallet_id' type='hidden' value='0'>
                                        <input id='finality_code' name='finality_code' type='hidden' value='SALDO'>
                                        <input id='operation_code' name='operation_code' type='hidden' value='664'>
                                    </div>
                                    {!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
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
    var table;
    $(function() {
        $("#barcode").keypress(function(e){
            //Se apertar enter, busca informações do barcode informado
            if(e.which == 9) {
                $.ajax("products/val/"+ $(this).val())
                .done(function(data) {
                    if(data != 0){
                        //Caso encontre o barcode, atualiza os inputs com os valores obtidos
                        $("#qty").val(data.qty);
                        $("#prev_qty").val(data.prev_qty);
                        $("#uom_code").val(data.uom_code);
                        $("#prev_uom_code").val(data.prev_uom_code);
                        $("#product_code").val(data.product_code);
                    }else{
                        alert('Barcode Invalido!!');
                    }
                })

            }
        })
                    
    });

</script>
@endsection