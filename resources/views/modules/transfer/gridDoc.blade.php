@extends('layouts.app')

@section('content')
    <div class="row" ng-app="grid_prod">
        <div class="col-md-12 pad-ct">
            <!-- Grid Principal -->
            <div class="panel panel-default" ng-controller="MainCtrl" >
                <div class="panel-heading">
                    @lang('models.transfer')
                </div>
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Alerta de erro / sucesso -->
                            @include('flash::message')
                            <div class="row buttons_grid">
                                    <div class="icon_grid" aria-label="@lang('buttons.add')" data-microtip-position="bottom" role="tooltip">
                                        <a href="{!! route('transfer.create') !!}">
                                            <img class='icon' src='{{asset('/icons/add.png') }}'>
                                        </a>
                                    </div>
                                    <button class="icon_grid" aria-label="@lang('buttons.filter')" data-microtip-position="bottom" role="tooltip" ng-click="toggleFiltering()">
                                        <img class='icon' src='{{asset('/icons/filter.png') }}'>
                                    </button>
                                    <div class="icon_grid" aria-label="@lang('buttons.stock_transfer')" data-microtip-position="bottom" role="tooltip">
                                            <a  href="{!! url('stockTransfer') !!}">
                                                <img class='icon' src='{{asset('/icons/transf_manual.png') }}'>
                                            </a>
                                    </div>
                            </div>
                            <div class="panel-body">
                                <div ui-grid="gridOptions" ui-grid-auto-resize  ui-grid-resize-columns ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state >
                                </div>
                                <!-- Botões com as opções para cada documento -->
                                @include('modules.transfer.buttonsDoc')
                                <div class="actionsGrid">
                                    <span aria-label="@lang('infos.actions_grid')" data-microtip-position="right" role="tooltip">
                                            <img class='icon' src='{{asset('/icons/information.png') }}' >
                                    </span>
                                    <button id="save" type="button" class="btn btn-success" ng-click="saveState('Autolog_GridTransf')">Salvar Grid</button>
                                    <button id="restore" type="button" class="btn btn-success" ng-click="restoreState('Autolog_GridTransf')">Restaurar Grid</button>
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
    <script src="js/angular/gridTransfer.js"></script>
@endsection