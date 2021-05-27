@extends('layouts.app')

@section('content')
<!-- BreadCrumb - Trilha  -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! route('inventory.index') !!}">@lang('models.inventory')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('models.reports')</li>
    </ol>
</nav>
<div class="row" ng-app="rep_inv">
    <div class="col-md-12 pad-ct">
        <div class="panel pbread panel-default" ng-controller="RepInventory" ng-init="setDocument('{{ $document->id }}','{{ $document->number }}')">
            <div class="panel-heading">
                <!-- Texto baseado no arquivo de linguagem -->
                @lang('reports.reportInv') : {{ $document->document_type_code }} - {{ $document->number }}  
            </div>
            <div class="row" >
                <div class="col-md-12">
                    <!-- Alerta de erro / sucesso -->
                    @include('flash::message')
                    <div id="msg_excluir"></div>
                    <!-- Botões de incluir, filtrar ,etc -->
                    <div class="row buttons_grid">
                        <div class="col-md-10">
                            <button class="icon_grid" aria-label="@lang('buttons.filter')" data-microtip-position="bottom" role="tooltip" ng-click="toggleFiltering()">
                                <img class='icon' src='{{asset('/icons/filter.png') }}'>
                            </button>
                            <button class="icon_grid" aria-label="@lang('buttons.filter')" data-microtip-position="bottom" role="tooltip" ng-click="changeGrouping()">
                                <span ng-if="group == 1">
                                    Agrupar por Barcode
                                </span>
                                <span ng-if="group == 2">
                                    Agrupar por Barcode
                                </span>
                            </button>
                            <button class="icon_grid" aria-label="Gerar PDF" data-microtip-position="bottom" role="tooltip" onClick="generatePDF()">
                                <img class='icon' src='{{asset('/icons/pdf.png') }}'>
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
                        <div id="gridd" ui-grid="gridOptions" ui-grid-auto-resize  ui-grid-resize-columns  ui-grid-pagination ui-grid-move-columns ui-grid-save-state ui-grid-grouping ui-grid-exporter >
                        </div>
                        <div class="actionsGrid">
                            <span aria-label="@lang('infos.actions_grid')" data-microtip-position="right" role="tooltip">
                                    <img class='icon' src='{{asset('/icons/information.png') }}' >
                            </span>
                            <button id="save" type="button" class="btn btn-success" ng-click="saveState()">Salvar Rel.</button>
                            <button id="restore" type="button" class="btn btn-success" ng-click="restoreState()">Restaurar Rel.</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="../../js/pdfmake/pdfmake.min.js"></script>
    <script src="../../js/pdfmake/vfs_fonts.js"></script>
    <script src="../../js/ui-grid/ui-grid.selection.min.js"></script>
    <script src="../../js/ui-grid/ui-grid.resizecolumns.min.js"></script>
    <script src="../../js/ui-grid/ui-grid.grouping.min.js"></script>
    <script src="../../js/ui-grid/ui-grid.exporter.min.js"></script>
    <script src="../../js/ui-grid/ui-grid.tree-base.min.js"></script>
    <script src="../../js/angular/repInventory.js"></script>

    <script>
    function generatePDF () {

        var dom_el = document.querySelector('[ng-controller="RepInventory"]');
        var ng_el = angular.element(dom_el);
        var ng_el_scope = ng_el.scope();
        var infosGrid = ng_el_scope.gridOptions.data;
        var arrayTable = [];
        infosGrid.forEach(function(column){
            arrayTable.push([column.location_code, column.product_code, column.product_description,  column.barcode, column.qty1]);
        })
        
        var docDefinition = {
                header: {
                    columns: [ {text: 'Inventário  {{ $document->number }} ', alignment: 'center', margin: [10,10,10,10] }]
                },
                content: [
                    { text: "Cliente: {{ $customer->name }} "},
                    { text: "Data: {{date('d/m/Y')}}", margin: [0,0,0,15]},
                    {
                        layout: 'lightHorizontalLines', // optional
                        table: {
                            // headers are automatically repeated if the table spans over multiple pages
                            // you can declare how many rows should be treated as headers
                            headerRows: 1,
                            widths: [ 50, 'auto', 'auto', 90, 60],
                            body: [
                                ['Setor', 'Produto', 'Descrição', 'Barcode',  'Quant.']
                            ].concat(arrayTable)
                    }
                    }
                ]
                };

        pdfMake.createPdf(docDefinition).open();

        
    }
    </script>
@endsection