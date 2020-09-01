@extends('layouts.app')

@section('content')
    <div class="row" ng-app="grid_inv">
        <div class="col-md-12 pad-ct">
            <!-- Grid Principal -->
            <div class="panel panel-default" ng-controller="MainCtrl" >
                <div class="panel-heading">
                    @lang('models.inventory')
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Alerta de erro / sucesso -->
                        <div id="msg_excluir"></div>
                        @include('flash::message')
                        @if (session('fileDownload'))
                            <div class="alert alert-success" role="alert"> 
                                <strong>Arquivo gerado com sucesso!</strong> 
                                <a id="download" href='{{url("download/".session("fileDownload"))}}'> Clique aqui </a> caso o download não tenha se iniciado automaticamente.
                            </div>
                        @endif
                        <!-- Botões de incluir, filtrar ,etc -->
                        <div class="row buttons_grid">
                            <div class="col-md-10">
                                <div class="icon_grid" aria-label="@lang('buttons.add')" data-microtip-position="bottom" role="tooltip">
                                    <a href="{!! route('inventory.create') !!}">
                                        <img class='icon' src='{{asset('/icons/add.png') }}'>
                                    </a>
                                </div>
                                <div class="icon_grid" aria-label="@lang('buttons.import')" data-microtip-position="bottom" role="tooltip">
                                    <a  href="{!! url('inventory/importFile') !!}">
                                        <img class='icon' src='{{asset('/icons/import.png') }}'>
                                    </a>
                                </div>
                                <button class="icon_grid" aria-label="@lang('buttons.filter')" data-microtip-position="bottom" role="tooltip" ng-click="toggleFiltering()">
                                    <img class='icon' src='{{asset('/icons/filter.png') }}'>
                                </button>
                            </div>
                            <!-- Botão de Refresh -->
                            <div class="col-md-2">
                                <button class="icon_grid" style="float: right" aria-label="@lang('buttons.refresh')" data-microtip-position="left" role="tooltip" ng-click="getFirstData()">
                                    <img class='icon' src='{{asset('/icons/refresh.png') }}'>
                                </button>
                            </div>
                        </div>
                        
                        <div class="panel-body">
                            <div id="gridd" ui-grid="gridOptions" ui-grid-auto-resize  ui-grid-resize-columns ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state >
                            </div>
                                <!-- Botões com as opções para cada documento -->
                                @include('modules.inventory.buttonsDoc')
                            
                            <div class="actionsGrid">
                                <span aria-label="@lang('infos.actions_grid')" data-microtip-position="right" role="tooltip">
                                        <img class='icon' src='{{asset('/icons/information.png') }}' >
                                </span>
                                <button id="save" type="button" class="btn btn-success" ng-click="saveState('Autolog_GridProd')">Salvar Grid</button>
                                <button id="restore" type="button" class="btn btn-success" ng-click="restoreState('Autolog_GridProd')">Restaurar Grid</button>
                            </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
@endsection
@section('scripts')
    <script src="js/angular/gridInv.js"></script>
    <script>
        $( function() {
            //Faz o download automatico do arquivo de exportação se existir o link
            if( $('#download').length){
                document.location = $('#download').attr ('href');
            }
                
        })
    </script>
@endsection