@extends('layouts.app')

@section('content')
<!-- BreadCrumb - Trilha  -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! route('inventory.index') !!}">@lang('models.inventory')</a></li>
        <li class="breadcrumb-item"><a href="{!! url('inventory/'.$document->id.'/items') !!}">@lang('buttons.detail')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('buttons.audit_acont')</li>
    </ol>
</nav>
<div class="row" ng-app="grid_inv">
    <div class="col-md-12 pad-ct">
        <!-- Grid de Detalhes  -->
        <div class="panel  pbread panel-default" ng-controller="auditCtrl" ng-init="showGridAudit('{{ $document->id }}','{{ $document->number }}', '{{$location_code}}')">
            <div class="panel-heading">
                @lang('models.audit_count'): {{ $document->document_type_code }} - {{ $document->number }} - @lang('models.location_code') - {{ $location_code}}
            </div>
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['route' => ['inventory.auditLocation', $document->id]]) !!}
                    <input id='location_code' name='location_code' type='hidden' value='{!! $location_code !!}'>
                    <input id='number' name='number' type='hidden' value='{!! $document->number !!}'>
                    <input id='document_type_code' name='document_type_code' type='hidden' value='{!! $document->document_type_code !!}'>
                    <!-- Alerta de erro / sucesso -->
                    <div id="msg_excluir"></div>
                    <!-- Alerta de erro / sucesso -->
                    @include('flash::message')
                    
                    <div class="panel-body invent">
                        <div ui-grid="gridDetalhes" ui-grid-auto-resize ui-grid-resize-columns ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state>
                        </div>
                        <!-- Botões com as opções para cada documento -->
                        @include('modules.inventory.buttonsItem')
                        <div class="actionsGrid">
                            <span aria-label="@lang('infos.actions_grid')" data-microtip-position="right" role="tooltip">
                                <img class='icon' src='{{asset('/icons/information.png') }}'>
                            </span>
                            <!-- <button id="save" type="button" class="btn btn-success" ng-click="saveAudit()">Salvar</button> -->
                            {!! Form::submit(Lang::get('buttons.save'), ['class' => 'btn btn-primary']) !!}
                            {!! Form::close() !!}
                            <!-- <button id="save" type="button" class="btn btn-success" ng-click="saveState('Autolog_GridTransf_Det')">Salvar Grid</button>
                                <button id="restore" type="button" class="btn btn-success" ng-click="restoreState('Autolog_GridTransf_Det')">Restaurar Grid</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="../../../js/angular/gridInv.js"></script>
@endsection