@extends('layouts.app')

@section('content')
    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{!! route('inventory.index') !!}"> @lang('models.inventory')</a></li>
            <li class="breadcrumb-item"> <a href="{!! url('inventory/'.$document->id.'/items') !!}"> @lang('models.items') </a> </li>
            <li class="breadcrumb-item active" aria-current="page">@lang('models.item_create')</li>
            </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel pbread panel-default" >
                <div class="panel-heading">
                    @lang('models.inventory') - @lang('models.item_create'): {{ $document->document_type_code }} -  {{ $document->number }}
                </div>
                <div class="panel pbread panel-default">
                    <div class="panel-body" >
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(['route' => 'inventory.storeItem']) !!}
                                <div class="form-group">
                                    @include('modules.inventory.fieldsItem')
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
