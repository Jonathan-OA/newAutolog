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
                            @include('flash::message')
                            {!! Form::open(['url' => 'receipt/importXml', 'files' => true, 'method' => 'POST']) !!}
                            <div class="form-group">
                                <div class="form_fields">
                                    <!-- Arquivo XML  -->
                                    {!! Form::label('fileXml', Lang::get('models.fileXml').':') !!}
                                    {!! Form::file('fileXml', ['required']) !!}
                                    <br><br>
                                    <div align="center">
                                        Exemplo de XML<br>
                                        <img src="{{asset('/img/arquivoXML.png') }}">
                                    </div>
                                    
                                </div>
                                <!-- Submit Field -->
                                {!! Form::submit(Lang::get('buttons.import'), ['class' => 'btn btn-primary']) !!}
                                <a href="{!! route('receipt.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
                            
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>   
            </div>
        </div>

    </div>
@endsection