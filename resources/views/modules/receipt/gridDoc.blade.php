@extends('layouts.app')

@section('content')
    <div class="row" ng-app="grid_rec">
        <div class="col-md-12 pad-ct">
            <!-- Grid Principal -->
            <div class="panel panel-default" ng-controller="MainCtrl" >
                <div class="panel-heading">
                    @lang('models.receipt')
                </div>
                <!-- Modal de Impressão de Documento-->
                <!-- Passa como parâmetro para a modal o nome do módulo para indicar o controller para acessar as funções -->
                <div class="modal fade" id="printModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    @include('layouts.printDoc', ['module' => 'receipt'])
                </div>
                <!-- -->
                <div class="row">
                    <div class="col-md-12">
                        <!-- Alerta de erro / sucesso -->
                        <div id="msg_excluir"></div>
                        @include('flash::message')
                        <div class="row buttons_grid">
                            <!-- Botões de Ação Gerais (Onda, etc..) -->
                            <div class="col-md-10">
                                <div class="icon_grid"  aria-label="@lang('buttons.add')" data-microtip-position="bottom" role="tooltip">
                                    <a href="{!! route('receipt.create') !!}">
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
                                    <button id="save" type="button" class="btn btn-success" ng-click="callRouteConfirm('./document/liberate/rec', 1, '@lang('buttons.msg_wave')','post')">@lang('buttons.wave')</button>
                                </div>
                            </div>
                            <!-- Botão de Refresh -->
                            <div class="col-md-2">
                                <button class="icon_grid" style="float: right" aria-label="@lang('buttons.refresh')" data-microtip-position="left" role="tooltip" ng-click="getFirstData()">
                                    <img class='icon' src='{{asset('/icons/refresh.png') }}'>
                                </button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div ui-grid="gridOptions" ui-grid-auto-resize  ui-grid-resize-columns ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state >
                            </div>
                            <!-- Botões com as opções para cada documento -->
                            @include('modules.receipt.buttonsDoc')
                            <div class="actionsGrid">
                                <span aria-label="@lang('infos.actions_grid')" data-microtip-position="right" role="tooltip">
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
    <script src="js/ui-grid/ui-grid.selection.min.js"></script>
    <script src="js/ui-grid/ui-grid.resizecolumns.min.js"></script>
    <script src="js/angular/gridRec.js"></script>
@endsection