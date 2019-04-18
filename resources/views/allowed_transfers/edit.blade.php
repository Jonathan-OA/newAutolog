@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.allowed_transfers') 
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::model($allowedTransfer, ['route' => ['allowedTransfers.update', $allowedTransfer->id], 'method' => 'patch']) !!}
                                @include('allowed_transfers.fields',['action' => "edit"])
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection