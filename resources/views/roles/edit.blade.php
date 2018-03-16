@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.roles')
                </div>
                <div class="panel panel-default">
                    @include('adminlte-templates::common.errors')
                    <div class="panel-body" >
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::model($roles, ['route' => ['roles.update', $roles->id], 'method' => 'patch']) !!}
                                  @include('roles.fields',['action' => "edit"])
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection