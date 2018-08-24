@extends('layouts.app')

@section('content')
    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"> <a href="{!! route('transfer.index') !!}"> @lang('models.transfer')</a></li>
        <li class="breadcrumb-item"> <a href="{!! url('transfer/'.$document->id.'/items') !!}"> @lang('models.items') </a> </li>
        <li class="breadcrumb-item active" aria-current="page">@lang('models.item_create')</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel pbread panel-default" >
                <div class="panel-heading">
                    @lang('models.transfer') - @lang('models.item_edit'): {{ $document->document_type_code }} -  {{ $document->number }}
                </div>
                <div class="panel pbread panel-default">
                    <div class="panel-body" >
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::model($documentItem, ['route' => ['transfer.updateItem', $documentItem->id], 'method' => 'patch']) !!}
                                    @include('modules.transfer.fieldsItem', ['action' => 'edit'])
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </div>
@endsection
