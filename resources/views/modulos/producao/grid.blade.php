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
                            Módulo de Produção - Documento: {{ documentNumber }}
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
                            <div ui-grid="gridOptions" ui-grid-auto-resize  ui-grid-resize-columns ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state class="grid">
                            </div>
                            <script type="text/ng-template" id="options">
                                <div id="hhhaaa" class="ui-grid-cell-contents" ng-controller="MainCtrl">
                                    <a href="#"  data-toggle="modal"  ng-click="showGridDet(row.entity.id, row.entity.number)" data-target="#myModal" class=" glyphicon glyphicon-zoom-in icon_action"></a>
                                    <a href="#" class=" glyphicon glyphicon glyphicon-tasks icon_action"></a>
                                </div>
                            </script>
                    </div>
                    <button id="save" type="button" class="btn btn-success" ng-click="saveState()">Save</button>
                    <button id="restore" type="button" class="btn btn-success" ng-click="restoreState()">Restore</button>
                 </div>
            </div>
            
        </div>
        
    </div>
    
@endsection
@section('scripts')
    <script src="js/angular/gridProd.js"></script>
@endsection