@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" ng-controller="DetCtrl" >
                <div class="panel-heading">
                    Módulo de Produção - Itens 
                </div>
                <div class="row buttons_grid">
                    <a href="#" id="button_menu" data-toggle="modal" data-target="#myModal"> 
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