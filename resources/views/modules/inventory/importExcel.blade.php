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
                            {!! Form::open(['url' => 'inventory/importExcel', 'files' => true, 'method' => 'POST']) !!}
                            <div class="form-group">
                                <div class="form_fields">
                                    <!-- Arquivo Excel  -->
                                    {!! Form::label('fileExcel', Lang::get('models.fileExcel').':') !!}
                                    {!! Form::file('fileExcel', ['required']) !!}
                                    <br><br>
                                    <div align="center">
                                        Exemplo de Planilha<br>
                                        <img src="{{asset('/img/planilhaExcel.png') }}">
                                    </div>
                                    <hr>
                                    <div class="panel-heading" >
                                        @lang('models.parameters')
                                    </div>
                                    <hr>
                                    <span aria-label="@lang('infos.param_count')" data-microtip-position="right" role="tooltip">
                                        <img class='icon' src='{{asset('/icons/information.png') }}' >
                                    </span>
                                    {!! Form::label('counts', Lang::get('parameters.param_count')) !!}
                                    {{ Form::radio('counts', '1' , false) }} 1
                                    {{ Form::radio('counts', '2' , true) }} 2
                                    {{ Form::radio('counts', '3' , false) }} 3 
                                    {{ Form::radio('counts', '4' , false) }} 4
                                    <br>
                                    <!-- Parâmetros de Inventário -->
                                    <span id="parameters">
                                        <span aria-label="@lang('infos.param_stock')" data-microtip-position="right" role="tooltip">
                                            <img class='icon' src='{{asset('/icons/information.png') }}' >
                                        </span>
                                        {!! Form::label('vstock', Lang::get('parameters.param_stock')) !!}
                                        {{ Form::radio('vstock', '1' , true) }} @lang('models.yes')
                                        {{ Form::radio('vstock', '0' , true) }} @lang('models.no')
                                        <br>
                                        <span aria-label="@lang('infos.param_product')" data-microtip-position="right" role="tooltip">
                                            <img class='icon' src='{{asset('/icons/information.png') }}' >
                                        </span>
                                        {!! Form::label('vproduct', Lang::get('parameters.param_product')) !!}
                                        {{ Form::radio('vproduct', '1' , true) }} @lang('models.yes')
                                        {{ Form::radio('vproduct', '0' , true) }} @lang('models.no')
                                        <br>
                                        <span aria-label="@lang('infos.param_location')" data-microtip-position="right" role="tooltip">
                                            <img class='icon' src='{{asset('/icons/information.png') }}' >
                                        </span>
                                        {!! Form::label('vlocation', Lang::get('parameters.param_location')) !!} 
                                        {{ Form::radio('vlocation', '1' , true) }} @lang('models.yes')
                                        {{ Form::radio('vlocation', '0' , true) }} @lang('models.no')
                                        <br>
                                    </span>
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