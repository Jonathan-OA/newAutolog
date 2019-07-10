@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('buttons.add') @lang('models.liberation_rules') - {!! $moviment_code !!}
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            @include('flash::message')
                            {!! Form::open(['route' => 'liberationRules.store']) !!}
                            <div class="form-group">
                                @include('liberation_rules.fields')
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div> 
            </div>
        </div>

    </div>
@endsection
