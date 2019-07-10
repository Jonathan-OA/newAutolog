@extends('layouts.app')

@section('content')
    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! route('production.index') !!}">@lang('models.production')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('buttons.detail')</li>
        </ol>
    </nav>
    <div class="row" ng-app="grid_prod">
        <div class="col-md-12 pad-ct">
            <!-- Grid de Detalhes  -->
            <div class="panel  pbread panel-default" ng-controller="DetCtrl" ng-init="showGrid('{{ $document->id }}','{{ $document->number }}')">
                <div class="panel-heading">
                    @lang('models.items_doc'): {{ $document->document_type_code }} -  {{ $document->number }}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Alerta de erro / sucesso -->
                        @include('flash::message')
                        <div class="row buttons_grid">
                                <!-- Adicionar novo item (somente para status pendente) -->
                                <div class="icon_grid" ng-show="({{$document->document_status_id}} == 0)" aria-label="@lang('buttons.add')" data-microtip-position="bottom" role="tooltip">
                                    <a href="{!! url('production/'.$document->id.'/items/create') !!}">
                                        <img class='icon' src='{{asset('/icons/add.png') }}'>
                                    </a>
                                </div>
                        </div>
                        <div class="panel-body">
                            <div ui-grid="gridDetalhes" ui-grid-auto-resize  ui-grid-resize-columns ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state >
                            </div>
                            <!-- Botões com as opções para cada documento -->
                            @include('modules.production.buttonsItem')
                            <div class="actionsGrid">
                                <span aria-label="@lang('infos.actions_grid_det')" data-microtip-position="right" role="tooltip">
                                        <img class='icon' src='{{asset('/icons/information.png') }}' >
                                </span>
                                <button id="save" type="button" class="btn btn-success" ng-click="saveState()">Salvar Grid</button>
                                <button id="restore" type="button" class="btn btn-success" ng-click="restoreState()">Restaurar Grid</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
@endsection
@section('scripts')
    <script src="../../js/ui-grid/ui-grid.selection.min.js"></script>
    <script src="../../js/angular/gridProd.js"></script>
@endsection