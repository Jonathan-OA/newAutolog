@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.document_imp') 
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['url' => 'inventory/confirmImportFile', 'files' => true, 'method' => 'POST']) !!}
                            <div class="form-group">
                                <div class="form_fields">
                                    @include('flash::message')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Cliente  -->
                                            {!! Form::label('customer_code', Lang::get('models.customer_code').':') !!}
                                            {!! Form::text('customer_code', (isset($customer_code)) ? $customer_code : '', ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'customers', 'required']) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {{-- Custo por Leitura no Inventário --}}
                                            {!! Form::label('cost', Lang::get('models.cost_inventory').':') !!}
                                            {!! Form::number('cost', (isset($cost)) ? $cost : '', ['class' => 'form-control', 'required']) !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Arquivo Excel  -->
                                            {!! Form::label('fileExcel', Lang::get('models.fileInput').':') !!}
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
                                            {!! Form::checkbox('fields[]', 'ean') !!} EAN
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