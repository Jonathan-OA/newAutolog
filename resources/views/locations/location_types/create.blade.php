@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.location_types')
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['route' => 'locationTypes.store']) !!}
                            <div class="form-group">
                                @include('locations.location_types.fields')
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
@endsection
