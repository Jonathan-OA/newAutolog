@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.stocks')
                </div>
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::model($stock, ['route' => ['stocks.update', $stock->id], 'method' => 'patch']) !!}
                                  @include('stocks.fields')
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection