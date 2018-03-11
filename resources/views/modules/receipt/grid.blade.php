@extends('layouts.app')

@section('content')
    <div class="row" >
        <div class="col-md-12 pad-ct">
            <div id="ModalTeste" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" >
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Módulo de Recebimento - Documento:
                            </div>
                            <div class="panel-body">
                                <div ui-grid="gridDetalhes"  class="grid" ></div>
                                    <button id="save" type="button" class="btn btn-success" ng-click="saveState()">Save</button>
                                    <button id="restore" type="button" class="btn btn-success" ng-click="restoreState()">Restore</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                 
            <div class="panel panel-default"  >
                <div class="panel-heading">
                    Módulo de Recebimento
                </div>
                <div class="row buttons_grid">
                    <a href="#" id="button_menu" data-toggle="modal" data-target="#ModalTeste"> 
                        <img class="icon_grid" src="{{ asset('/icons/add.png') }}" alt="Adicionar">
                    </a>
                    <a href="#" id="button_menu"> 
                        <img class="icon_grid" src="{{ asset('/icons/import.png') }}" alt="Importar">
                    </a>
                    <a href="#" id="toggleFiltering" ng-click="toggleFiltering()"> 
                        <img class="icon_grid" src="{{ asset('/icons/filter.png') }}" alt="Filtrar">
                    </a>

                </div>
                 <div class="panel-body">
                    <div id="example1" class="hot handsontable"></div>
                 </div>
            </div>
            
        </div>
        
    </div>
    
@endsection
@section('scripts')
    <script>
    $( document ).ready(function() {

        var data = [
                    ["", "Ford", "Volvo", "Toyota", "Honda"],
                    ["2014", 10, 11, 12, 13],
                    ["2015", 20, 11, 14, 13],
                    ["2016", 30, 15, 12, 13]
                    ];

                    var container = document.getElementById('example1');
                    var hot = new Handsontable(container, {
                    data: data,
                    minSpareRows: 1,
                    rowHeaders: true,
                    colHeaders: true,
                    contextMenu: true
                    });

    });
    </script>
@endsection