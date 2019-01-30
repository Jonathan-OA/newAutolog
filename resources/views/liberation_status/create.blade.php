@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.liberation_status')
                </div>
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(['route' => 'liberationStatus.store']) !!}
                                <div class="form-group">
                                    @include('liberation_status.fields')
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>

    </div>
@endsection
