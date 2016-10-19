@extends('layouts.app')

@section('content')
    <div class="row" ng-app="grid_prod">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" ng-controller="MainCtrl" >
                <div class="panel-heading">
                    Módulo de Produção
                </div>
                <div class="row buttons_grid">
                    <a href="#" id="button_menu" data-toggle="modal" data-target="#ModalTeste"> 
                        <img class="icon_grid" src="<% asset('/icons/add.png') %>" alt="Adicionar">
                    </a>
                    <a href="#" id="button_menu"> 
                        <img class="icon_grid" src="<% asset('/icons/import.png') %>" alt="Importar">
                    </a>
                    <a href="#" id="toggleFiltering" ng-click="toggleFiltering()"> 
                        <img class="icon_grid" src="<% asset('/icons/filter.png') %>" alt="Filtrar">
                    </a>

                </div>
                 <div class="panel-body">
                    <div>
                            <div ui-grid="gridOptions"  ui-grid-auto-resize ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state class="grid">
                            </div>
                            <script type="text/ng-template" id="options">
                                <div id="hhhaaa" class="ui-grid-cell-contents" ng-controller="DetCtrl">
                                    <a href="#"  data-toggle="modal"  ng-click="showGrid(4)" data-target="#myModal" class=" glyphicon glyphicon-zoom-in icon_action"></a>
                                    <a href="#" class=" glyphicon glyphicon glyphicon-tasks icon_action"></a>
                                </div>
                            </script>
                    </div>
                    <button id="save" type="button" class="btn btn-success" ng-click="saveState()">Save</button>
                    <button id="restore" type="button" class="btn btn-success" ng-click="restoreState()">Restore</button>
                 </div>
            </div>
            
        </div>
        <!-- Grid de Detalhes (Carrega quando clica na lupa na coluna de opções) -->
        <div id="myModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" ng-controller="DetCtrl">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div ui-grid="gridDetalhes" ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state class="grid" ng-show="dataLoaded">
                    </div>
                </div>
            </div>
    </div>
    
@endsection
@section('scripts')
    <script src="js/angular/gridProd.js"></script>
@endsection