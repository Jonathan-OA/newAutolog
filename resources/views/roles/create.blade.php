@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.roles')
                </div>
                <div class="panel panel-default">
                    
                    <div class="panel-body" >
                    
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(['route' => 'roles.store']) !!}
                                <div class="form-group">
                                
                                    @include('roles.fields')
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
