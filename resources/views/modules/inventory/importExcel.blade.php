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
                                <!-- Numero do Inventario  -->
                                {!! Form::label('number', Lang::get('models.document_number').':') !!}
                                {!! Form::text('number', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group">
                                <!-- Arquivo Excel  -->
                                {!! Form::label('fileExcel', Lang::get('models.fileExcel').':') !!}
                                {!! Form::file('fileExcel') !!}
                            </div>
                            
                            <!-- Submit Field -->
                            {!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('production.index') !!}" class="btn btn-default">@lang('buttons.cancel')</a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>   
            </div>
        </div>

    </div>
@endsection