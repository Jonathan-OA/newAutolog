@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.printer_types')
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['route' => 'printerTypes.store']) !!}
                            <div class="form-group">
                                @include('print.printer_types.fields')
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>  
            </div>
        </div>

    </div>
@endsection