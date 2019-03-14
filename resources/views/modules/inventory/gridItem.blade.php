@extends('layouts.app')

@section('content')
    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! route('inventory.index') !!}">@lang('models.inventory')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('buttons.detail')</li>
        </ol>
    </nav>
    <div class="row" ng-app="grid_inv">
        <div class="col-md-12 pad-ct">
            <!-- Grid de Detalhes  -->
            <div class="panel  pbread panel-default" ng-controller="DetCtrl" ng-init="showGrid('{{ $document->id }}','{{ $document->number }}')">
                <div class="panel-heading">
                    @lang('models.items_doc'): {{ $document->document_type_code }} -  {{ $document->number }}
                </div>
                <div class="panel pbread panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Alerta de erro / sucesso -->
                            @include('flash::message')
                            <div class="row buttons_grid">
                                    <div class="icon_grid" aria-label="@lang('buttons.add')" data-microtip-position="bottom" role="tooltip">
                                        <a href="{!! url('inventory/'.$document->id.'/selectItems') !!}">
                                            <img class='icon' src='{{asset('/icons/add.png') }}'>
                                        </a>
                                    </div>
                            </div>
                            <div class="panel-body">
                                <div ui-grid="gridDetalhes" ui-grid-auto-resize  ui-grid-resize-columns ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state >
                                </div>
                                <!-- Botões com as opções para cada documento -->
                                @include('modules.inventory.buttonsItem')
                                <div class="actionsGrid">
                                    <span aria-label="@lang('infos.actions_grid')" data-microtip-position="right" role="tooltip">
                                            <img class='icon' src='{{asset('/icons/information.png') }}' >
                                    </span>
                                    <button id="save" type="button" class="btn btn-success" ng-click="saveState('Autolog_GridTransf_Det')">Salvar Grid</button>
                                    <button id="restore" type="button" class="btn btn-success" ng-click="restoreState('Autolog_GridTransf_Det')">Restaurar Grid</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
@endsection
@section('scripts')
    <script src="../../js/angular/gridInv.js"></script>
@endsection