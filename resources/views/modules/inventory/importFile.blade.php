@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.document_imp') - Inventário
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['url' => 'inventory/confirmImportFile', 'files' => true, 'method' => 'POST', 'id' => 'formImport']) !!}
                            <div class="form-group">
                                <div class="form_fields">
                                    @include('flash::message')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Cliente  -->
                                            {!! Form::label('customer_code', "*".Lang::get('models.customer_code').':') !!}
                                            {!! Form::text('customer_code', (isset($customer_code)) ? $customer_code : '', ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'customers', 'required']) !!}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! Form::label('billing_type', "*".Lang::get('models.billing_type').':') !!}
                                            {{ Form::radio('billing_type', 'VL' , false) }} Por Leitura
                                            {{ Form::radio('billing_type', 'VF' , true) }} Valor Fechado
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{-- Custo por Leitura no Inventário --}}
                                            {!! Form::label('cost', "*".Lang::get('models.cost_inventory').':') !!}
                                            {!! Form::number('cost', (isset($inventory_value)) ? $inventory_value : '', ['class' => 'form-control', 'step' => '0.01', 'id' => 'cost','required']) !!}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{-- Custo Extras (Importação / Conferência) --}}
                                            <span aria-label="@lang('infos.documents.extra_cost')" data-microtip-position="right" role="tooltip">
                                                <img class='icon' src='{{asset('/icons/information.png') }}' >
                                            </span>
                                            {!! Form::label('extra_cost', "".Lang::get('models.extra_cost').':') !!}
                                            {!! Form::number('extra_cost', (isset($inventory_extra_value)) ? $inventory_extra_value : '', ['class' => 'form-control', 'id' => 'extra_cost', 'step' => '0.01']) !!}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Arquivo Excel  -->
                                            {!! Form::label('fileExcel', "*".Lang::get('models.fileInput').':') !!}
                                            {!! Form::file('fileExcel', ['required']) !!}
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-6" align="center">
                                            Exemplo de Planilha<br>
                                            <img src="{{asset('/img/planilhaExcel.png') }}">
                                        </div>
                                        <div class="col-md-6" align="center">
                                            Exemplo de TXT<br>
                                            <img src="{{asset('/img/arquivoTxt.png') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            {!! Form::label('cost', Lang::get('models.infos_import').':') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            {!! Form::checkbox('fields[]', 'ean' ) !!} EAN
                                        </div>
                                        <div class="col-md-2">
                                        {!! Form::checkbox('fields[]', 'dsc') !!} Descrição
                                        </div>  
                                        <div class="col-md-2">
                                            {!! Form::checkbox('fields[]', 'prd') !!} Cod. Interno
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            {!! Form::checkbox('fields[]', 'qde') !!} Quantidade
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::checkbox('fields[]', 'lot') !!} Lote
                                        </div>
                                        <div class="col-md-2">
                                            {!! Form::checkbox('fields[]', 'dep') !!} Depósito
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            {!! Form::checkbox('fields[]', 'end') !!} Endereço
                                        </div>
                                    </div>
                                </div>
                                <div> 
                                    <p> Extensões aceitas: CSV, XML e TXT
                                </div>
                                <!-- Submit Field -->
                                {!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
                                <a href="{!! route('inventory.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
                            
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>   
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script src="{{ URL::asset('/js/jquery/jquery.mask.js') }}"></script>
    <script>
        $( function() {

             //Masks
             //$('#cost').mask('#.##0,00');
             //$('#extra_cost').mask('#.##0,00');

            //Ao clicar em submit valida se ao menos um campo foi preenchido das infos do arquivo
            $("#formImport").submit(function(e){
                if($('input[name="fields[]"]:checked').length == 0){
                    e.preventDefault();
                    alert("Preencha ao menos uma das informações presentes no arquivo.");
                    $('#loadingModal').modal('toggle');
                }
               
                    
                
            
            })
        })
    </script>
@endsection