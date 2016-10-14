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
                            <div ui-grid="gridOptions" ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state class="grid">
                            </div>
                            <script type="text/ng-template" id="options">
                                <div id="hhhaaa" class="ui-grid-cell-contents">
                                    <a id="hhhaaa" data-toggle="modal" href="/producao/detalhes/4" data-target="#myModal" class=" glyphicon glyphicon-zoom-in icon_action" rel="modal"></a>
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
    <!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-body">
                <div class="panel panel-default" ng-controller="MainCtrl" >
                <div class="panel-heading">
                    Módulo de Produção
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div> -->
@endsection
@section('scripts')
    <script src="js/angular/gridProd.js"></script>
@endsection