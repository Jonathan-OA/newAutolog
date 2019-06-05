@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.receipt') - @lang('models.document_create')
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['route' => 'receipt.store']) !!}
                            <div class="form-group">
                                @include('modules.receipt.fieldsDoc')
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>   
            </div>
        </div>

    </div>
@endsection
