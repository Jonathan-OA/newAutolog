@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.departments')
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['route' => 'departments.store']) !!}
                            <div class="form-group">
                                @include('locations.departments.fields')
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
@endsection
