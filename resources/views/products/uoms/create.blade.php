@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.uoms')
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['route' => 'uoms.store']) !!}
                            <div class="form-group">
                                @include('products.uoms.fields')
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div> 
            </div>
        </div>

    </div>
@endsection
