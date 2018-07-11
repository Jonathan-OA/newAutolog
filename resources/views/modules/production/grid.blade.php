@extends('layouts.app')

@section('content')
    <div class="row" ng-app="grid_prod">
        <div class="col-md-12 pad-ct">

            <!-- Grid de Detalhes (Carrega quando clica na lupa na coluna de opções) -->  
            <div id="myModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" ng-controller="DetCtrl">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Módulo de Produção - Documento: {% documentNumber %}
                            </div>
                            <div class="panel-body">
                                <div ui-grid="gridDetalhes" ui-grid-auto-resize ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state class="grid" ></div>
                                    <button id="save" type="button" class="btn btn-success" ng-click="saveState()">Save</button>
                                    <button id="restore" type="button" class="btn btn-success" ng-click="restoreState()">Restore</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <!-- Grid Principal -->
            <div class="panel panel-default" ng-controller="MainCtrl" >
                <div class="panel-heading">
                    Módulo de Produção
                </div>
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Alerta de erro / sucesso -->
                            @include('flash::message')
                            <div class="row buttons_grid">
                                    <button class="icon_grid" aria-label="@lang('buttons.add')" data-microtip-position="bottom" role="tooltip">
                                        <img class='icon' src='{{asset('/icons/add.png') }}'>
                                    </button>
                                    <button class="icon_grid" aria-label="@lang('buttons.import')" data-microtip-position="bottom" role="tooltip">
                                        <img class='icon' src='{{asset('/icons/import.png') }}'>
                                    </button>
                                    <button class="icon_grid" aria-label="@lang('buttons.filter')" data-microtip-position="bottom" role="tooltip" ng-click="toggleFiltering()">
                                        <img class='icon' src='{{asset('/icons/filter.png') }}'>
                                    </button>
                            </div>
                            <div class="panel-body">
                                <div ui-grid="gridOptions" ui-grid-auto-resize  ui-grid-resize-columns ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state >
                                </div>
                                    <!-- Botões com as opções para cada documento -->
                                    @include('modules.production.buttons')
                                <button id="save" type="button" class="btn btn-success" ng-click="saveState()">Save</button>
                                <button id="restore" type="button" class="btn btn-success" ng-click="restoreState()">Restore</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
@endsection
@section('scripts')
    <script src="js/angular/gridProd.js"></script>
@endsection