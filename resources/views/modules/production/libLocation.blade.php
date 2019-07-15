@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.document_lib') - {{$document->document_type_code}} {{$document->number}}
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['url' => 'production/'.$document->id.'/liberate']) !!}
                            <div class="form-group">
                                <!-- Location Field -->
                                {!! Form::label('location_code', Lang::get('models.dest_location_code').':') !!}
                                {!! Form::text('location_code', null, ['class' => 'form-control', 'required', 'id' => 'autocomplete', 'table' => 'locations', 'filters' => 'SECTOR_CODE:PROD']) !!}
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