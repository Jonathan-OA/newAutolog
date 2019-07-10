@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('buttons.edit') @lang('models.liberation_rules') - {!! $moviment_code !!}
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            @include('flash::message')
                            {!! Form::model($liberationRule, ['route' => ['liberationRules.update', $liberationRule->id], 'method' => 'patch']) !!}
                                @include('liberation_rules.fields',['action' => "edit"])
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection