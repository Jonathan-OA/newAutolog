@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Suppliers
                </div>
                <div class="panel panel-default">
                    @include('adminlte-templates::common.errors')
                    <div class="panel-body" >
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::model($suppliers, ['route' => ['suppliers.update', $suppliers->id], 'method' => 'patch']) !!}
                                  @include('suppliers.fields')
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection