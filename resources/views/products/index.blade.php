@extends('layouts.app')

@section('content')
<div class="row" ng-app="grid_product">
    <div class="col-md-12 pad-ct">
        <!-- Grid Principal -->
        <div class="panel panel-default" ng-controller="MainCtrl">
            <div class="panel-heading ptabs">
                <!-- Abas -->
                <ul class="nav nav-tabs">
                    <!-- Textos baseados no arquivo de linguagem -->
                    <li class="active-l"><a href="#">@lang('models.products') </a></li>
                    <li><a href="{!! route('productTypes.index') !!}">@lang('models.product_types')</a></li>
                    <li><a href="{!! route('groups.index') !!}">@lang('models.groups')</a></li>
                    <li><a href="{!! route('uoms.index') !!}">@lang('models.uoms')</a></li>
                    <li><a href="{!! route('blockedGroups.index') !!}">@lang('models.blocked_groups')</a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Alerta de erro / sucesso -->
                    @include('flash::message')
                    <div id="msg_excluir"></div>
                    <div class="row buttons_grid">
                        <div class="icon_grid" aria-label="@lang('buttons.add')" data-microtip-position="bottom" role="tooltip">
                            <a href="{!! route('products.create') !!}">
                                <img class='icon' src='{{asset('/icons/add.png') }}'>
                            </a>
                        </div>
                        <button class="icon_grid" aria-label="@lang('buttons.filter')" data-microtip-position="bottom" role="tooltip" ng-click="toggleFiltering()">
                            <img class='icon' src='{{asset('/icons/filter.png') }}'>
                        </button>
                        <!-- Visualizar Logs  -->
                        <a class="icon_logs" href="{!! url('logs/products_') !!}" aria-label="@lang('buttons.logs')" data-microtip-position="left" role="tooltip">
                            <img class='icon' src='{{asset('/icons/logs.png') }}'>
                        </a>
                    </div>
                    <div class="panel-body">
                        <div id="gridd" ui-grid="gridOptions" ui-grid-auto-resize ui-grid-resize-columns ui-grid-selection ui-grid-pagination ui-grid-move-columns ui-grid-save-state>
                        </div>
                        <!-- Botões com as opções para cada documento -->
                        @include('products.buttons')

                        <div class="actionsGrid">
                            <span aria-label="@lang('infos.actions_grid')" data-microtip-position="right" role="tooltip">
                                <img class='icon' src='{{asset('/icons/information.png') }}'>
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
<script src="js/angular/gridProducts.js"></script>
<script>
    $(function() {
        //Faz o download automatico do arquivo de exportação se existir o link
        if ($('#download').length) {
            document.location = $('#download').attr('href');
        }

    })
</script>
@endsection