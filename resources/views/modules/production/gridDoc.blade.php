@extends('layouts.app')

@section('content')
    <div class="row" ng-app="grid_prod">
        <div class="col-md-12 pad-ct">
            <!-- Grid Principal -->
            <div class="panel panel-default" ng-controller="MainCtrl" >
                <div class="panel-heading">
                    @lang('models.production')
                </div>
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Alerta de erro / sucesso -->
                            <div id="msg_excluir"></div>
                            @include('flash::message')
                            <div class="row buttons_grid">
                                    <div class="icon_grid"  aria-label="@lang('buttons.add')" data-microtip-position="bottom" role="tooltip">
                                        <a href="{!! route('production.create') !!}">
                                            <img class='icon' src='{{asset('/icons/add.png') }}'>
                                        </a>
                                    </div>
                                    <div class="icon_grid" aria-label="@lang('buttons.import')" data-microtip-position="bottom" role="tooltip">
                                        <a  href="#">
                                            <img class='icon' src='{{asset('/icons/import.png') }}'>
                                        </a>
                                    </div>
                                    <button id="testemicrotip" class="icon_grid" aria-label="@lang('buttons.filter')" data-microtip-position="bottom" role="tooltip" ng-click="toggleFiltering()">
                                        <img class='icon' src='{{asset('/icons/filter.png') }}'>
                                    </button>
                                    <button class="icon_grid" aria-label="@lang('buttons.wave')" data-microtip-position="bottom" role="tooltip" ng-click="toggleMultiSelect()">
                                        <img class='icon' src='{{asset('/icons/wave.png') }}'>
                                    </button>
                                    <div id="wave_grid" >
                                        @lang('infos.select_wave') {% docsSelected %}
                                        <button id="save" type="button" class="btn btn-success" ng-click="callRouteConfirm('./document/liberate/prod', 1, '@lang('buttons.msg_wave')','post')">@lang('buttons.wave')</button>
                                    </div>
                            </div>
                            <div class="panel-body">
                                <div ui-grid="gridOptions" ui-grid-auto-resize  ui-grid-resize-columns ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state >
                                </div>
                                    <!-- Botões com as opções para cada documento -->
                                    @include('modules.production.buttonsDoc')
                                <div class="actionsGrid">
                                    <span aria-label="@lang('infos.actions_grid')" data-microtip-position="right" role="tooltip">
                                            <img class='icon' src='{{asset('/icons/information.png') }}' >
                                    </span>
                                    <button id="save" type="button" class="btn btn-success" ng-click="saveState('Autolog_GridInv')">Salvar Grid</button>
                                    <button id="restore" type="button" class="btn btn-success" ng-click="restoreState('Autolog_GridInv')">Restaurar Grid</button>
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
    <script src="js/ui-grid/ui-grid.selection.min.js"></script>
    <script src="js/angular/gridProd.js"></script>
@endsection