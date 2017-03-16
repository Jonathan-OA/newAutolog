@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   Customers
                </div>
                
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            @include('flash::message')
                            <div class="row buttons_grid">
                                <a class="btn btn-success"  href="{!! route('customers.create') !!}">Adicionar</a>
                            </div>
                            <div class="panel-body">
                                @include('customers.table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection