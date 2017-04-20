@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Vehicles
                </div>
                <div class="panel panel-default">
                    @include('adminlte-templates::common.errors')
                    <div class="panel-body" >
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(['route' => 'vehicles.store']) !!}
                                <div class="form-group">
                                    @include('vehicles.fields')
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
