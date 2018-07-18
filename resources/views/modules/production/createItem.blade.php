@extends('layouts.app')

@section('content')
    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{!! route('production.index') !!}"> @lang('models.production')</a></li>
            <li class="breadcrumb-item"> <a href="{!! url('production/'.$document->id.'/items') !!}"> @lang('models.items') </a> </li>
            <li class="breadcrumb-item active" aria-current="page">@lang('models.item_create')</li>
            </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    @lang('models.production') - @lang('models.item_create'): {{ $document->document_type_code }} -  {{ $document->number }}
                </div>
                <div class="panel panel-default">
                    <div class="panel-body" >
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(['route' => 'production.store']) !!}
                                <div class="form-group">
                                    @include('modules.production.fieldsItem')
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>

    </div>
@endsection
