@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    Permissions
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">

                            @include('flash::message')
                            <div class="content" style="padding-top: 30px;">
                                <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('permissions.create') !!}">Add New</a>
                                @include('permissions.table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Permissions</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('permissions.create') !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('permissions.table')
            </div>
        </div>
    </div>
@endsection

