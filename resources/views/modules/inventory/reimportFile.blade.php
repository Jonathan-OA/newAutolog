@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('buttons.reload_file') - Inventário: {{$document->number}}
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['url' => 'inventory/reimportFile', 'files' => true, 'method' => 'POST', 'id' => 'formReimport']) !!}
                            <div class="form-group">
                                <div class="form_fields">
                                    @include('flash::message')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Cliente  -->
                                            {!! Form::label('customer_code', "*".Lang::get('models.customer_code').':') !!}
                                            {!! Form::text('customer_code', $document->customer_code, ['class' => 'form-control', 'id' => 'autocomplete', 'table' => 'customers', 'required', 'readonly']) !!}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="alert alert-info">
                                        <strong>@lang('infos.attention.reimport')</strong>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Arquivo Excel  -->
                                            {!! Form::label('fileExcel', "*".Lang::get('models.fileInput').':') !!}
                                            {!! Form::file('fileExcel', ['required']) !!}
                                        </div>
                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            {!! Form::label('cost', Lang::get('models.infos_import').':') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                    @foreach (json_decode($document->order_fields, true) as $key => $value)
                                        @switch($key)
                                            @case('ean')
                                                <div class="col-md-2">
                                                    {!! Form::checkbox('fields[]', 'ean',  ['checked','disabled']) !!} EAN
                                                </div>
                                                @break
                                            @case('dsc')
                                                <div class="col-md-2">
                                                {!! Form::checkbox('fields[]', 'dsc',  ['checked','disabled']) !!} Descrição
                                                </div> 
                                                @break
                                            @case('prd')
                                                <div class="col-md-2">
                                                    {!! Form::checkbox('fields[]', 'prd',  ['checked','disabled']) !!} Cod. Interno
                                                </div> 
                                                @break
                                            @case('qde')
                                                <div class="col-md-2">
                                                    {!! Form::checkbox('fields[]', 'qde',  ['checked','disabled']) !!} Quantidade
                                                </div> 
                                                @break
                                            @case('lot')
                                                <div class="col-md-2">
                                                    {!! Form::checkbox('fields[]', 'lot',  ['checked','disabled']) !!} Lote
                                                </div> 
                                                @break
                                            @case('dep')
                                                <div class="col-md-2">
                                                    {!! Form::checkbox('fields[]', 'dep',  ['checked','disabled']) !!} Depósito
                                                </div> 
                                                @break
                                            @case('end')
                                                <div class="col-md-2">
                                                    {!! Form::checkbox('fields[]', 'end',  ['checked','disabled']) !!} Endereço
                                                </div> 
                                                @break
                                        @endswitch
                                    @endforeach
                                </div>
                            </div>
                            {!! Form::hidden('document_number', $document->number) !!}
                            {!! Form::hidden('document_id', $document->id) !!}

                            <!-- Submit Field -->
                            {!! Form::submit(Lang::get('buttons.reimport'), ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('inventory.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
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
        $( function() {
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