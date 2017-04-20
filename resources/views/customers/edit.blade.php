@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Customers
                </div>
                <div class="panel panel-default">
                    @include('adminlte-templates::common.errors')
                    <div class="panel-body" >
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::model($customers, ['route' => ['customers.update', $customers->id], 'method' => 'patch']) !!}
                                  @include('customers.fields')
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection