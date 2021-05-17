//Geração dos Grids de Inventário
//Alteração das tags padrão do Angular de {{ }} para {% %}
var app = angular.module('rep_inv', ['ui.grid',
    'ui.grid.pagination', 'ui.grid.saveState',
    'ui.grid.moveColumns', 'ui.grid.autoResize',
    'ui.grid.resizeColumns', 'ui.grid.exporter',
    'ui.grid.grouping'
], function($interpolateProvider) {
    $interpolateProvider.startSymbol('{%');
    $interpolateProvider.endSymbol('%}');
});

//Config pra remover erros inuteis
app.config(['$qProvider', function($qProvider) {
    $qProvider.errorOnUnhandledRejections(false);
}]);

//Funções reaproveitadas no grid de documentos e no grid de itens
app.run(['$rootScope', function($rootScope) {

    //Salva grid modificado
    $rootScope.saveStateRS = function($scope, $http) {

        //$rootScope.page = documents: veio do grid de documentos
        //$rootScope.page = items : veio do grid de itens
        if ($rootScope.page == 'documents') {
            $scopeC = $scope.gridApi;
            $url = 'api/grid';
        } else {
            $scopeC = $scope.gridApiDet;
            $url = '../../api/grid';
        }
        var datas = $scopeC.saveState.save();
        //Salva na sessão
        localStorage.setItem($scope.gridCode, JSON.stringify(datas));
        //Salva no banco
        $http({
            method: 'POST',
            url: $url,
            data: { 'config': JSON.stringify(datas), 'code': $scope.gridCode }
        }).then(function(res) {
            //Mostra mensagem de sucesso ou erro
            $('.alert').remove();
            $('#msg_excluir').html('<div class="alert alert-' + res.data[0] + '">' + res.data[1] + '</div>');
            $('.alert').html(res.data[1]);
        }, function(error) {
            console.log("Erro ao buscar Grid Salvo");
        });
    }

    //Restaura grid salvo anteriormente
    $rootScope.restoreStateRS = function($scope, $http) {

        //$rootScope.page = documents: veio do grid de documentos
        //$rootScope.page = items : veio do grid de itens
        if ($rootScope.page == 'documents') {
            $scopeC = $scope.gridApi;
            $url = 'api/grid/';
        } else {
            $scopeC = $scope.gridApiDet;
            $url = '../../api/grid/';
        }

        var columns = localStorage.getItem($scope.gridCode);
        if (columns) {
            $scopeC.saveState.restore($scope, JSON.parse(columns));
        } else {
            //Se não encontrou a configuração na sessão, busca no banco
            $http({
                method: 'GET',
                url: $url + $scope.gridCode
            }).then(function(res) {
                $scopeC.saveState.restore($scope, res.data);
            });
        }

        //$('.alert').remove();
    }

}]);


//Grid de documentos
app.controller('RepInventory', ['$rootScope', '$scope', '$http', 'uiGridConstants',  'uiGridGroupingConstants', '$timeout', '$animate', '$compile', '$filter',
    function($rootScope, $scope, $http, uiGridConstants, uiGridGroupingConstants, $timeout, $animate, $compile, $filter) {
       //Código do grid a ser salvo / recuperado no banco
         $scope.gridCode = 'AUTOLOGWMS_repInv';
        //Variavel de controle para buscar o filtro externo apenas uma vez
        $scope.hasFilter = false;
        $scope.group = 1; //Group 1 = Endereço; 2 = Barcode
        $rootScope.page = 'documents';
        $scope.documentId = "";
        $scope.documentNumber = "";
        $scope.gridOptions = {
            enableFullRowSelection: false,
            enableRowSelection: false,
            rowSelection: false,
            multiSelect: false,
            enableFiltering: false,
            fastWatch: true,
            enableColumnResizing: true,
            enableHorizontalScrollbar: true,
            treeRowHeaderAlwaysVisible: false,
            showColumnFooter: true,
            enableGridMenu: true,
            exporterMenuCsv: false,
            exporterMenuExcel: false,
            exporterPdfFilename: 'relatorio_inv_'+$scope.documentNumber+'.pdf',
            exporterPdfDefaultStyle: {fontSize: 9},
            exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
            exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'black'},
            exporterPdfHeader: {
                columns: [
                  { text: '23/04/2021 - 19:12', alignment: 'left' },
                  { text: 'Inventário', alignment: 'center' }
                ]
              },
            exporterPdfFooter: function ( currentPage, pageCount ) {
            return { text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle' };
            },
            exporterPdfCustomFormatter: function ( docDefinition ) {
            docDefinition.styles.headerStyle = { fontSize: 22, bold: true };
            docDefinition.styles.footerStyle = { fontSize: 10, bold: true };
            return docDefinition;
            },
            exporterPdfOrientation: 'portrait',
            exporterPdfPageSize: 'A4',
            exporterPdfMaxGridWidth: 500,
            onRegisterApi: function(gridApi) {
                $scope.gridApi = gridApi;
                $timeout(function() {
                    $scope.restoreState($scope.gridCode, $http);
                }, 50);
                //Chama a função que preenche o grid
                $scope.getFirstData();
            },
            enableGridMenu: true,
            columnDefs: [
                { name: 'Endereço', field: 'location_code', cellClass:'align-left', grouping: { groupPriority: 1 }, minWidth: 150, 
                  cellTemplate: '<div ng-if="!col.grouping || col.grouping.groupPriority === undefined || col.grouping.groupPriority === null || ( row.groupHeader && col.grouping.groupPriority === row.treeLevel )" class="ui-grid-cell-contents" title="TOOLTIP">{{COL_FIELD CUSTOM_FILTERS}}</div>',
                  footerCellTemplate: '<div class="ui-grid-cell-contents">Total:</div>' },
                { name: 'Produto', field: 'product_code',minWidth: 90 },
                { name: 'Barcode', field: 'barcode',  minWidth: 170, cellClass:'align-left' },
                { name: 'Descrição', field: 'product_description', cellClass:'align-left', minWidth: 400, customTreeAggregationFinalizerFn: function( aggregation ) {
                    aggregation.rendered = aggregation.value;
                  },footerCellTemplate: '<div class="ui-grid-cell-contents"></div>' },
                { name: 'Lote', field: 'batch', minWidth: 90 },
                { name: 'Validade', field: 'due_date', minWidth: 90 , type: 'date', cellFilter: "dateFilter"},
                { name: '1ª Cont.', field: 'qty1', treeAggregationType: uiGridGroupingConstants.aggregation.SUM, customTreeAggregationFinalizerFn: function( aggregation ) {
                    aggregation.rendered = aggregation.value;
                  }, minWidth: 70  },
                { name: '2ª Cont.', field: 'qty2', minWidth: 60 },
                { name: 'UOM', field: 'prim_uom_code', minWidth: 40 },
                { name: 'Usuário', field: 'name', minWidth: 160 },
                { name: 'Qde Prev', field: 'qty_wms', minWidth: 30 },
                

            ],
            enablePaginationControls: true,
            paginationPageSize: 3000,
            rowTemplate: '<div ng-click="grid.appScope.clickRow(row, col, $event)" ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.uid" class="ui-grid-cell" ng-class="col.colIndex()" ui-grid-cell></div>',
        };

        //Se houver scroll no grid, fecha as opções da linha
        $scope.$on('scrolled', function(event, args) {
            $('#options').remove();
        });

        $scope.callRouteConfirm = function(route, async = 0, msg, type = "get") {
            if (confirm(msg)) {
                //Chama função global que chama uma rota ao clicar no botão
                $rootScope.callRouteRS(route, async, type, $scope);
            }
        }

        $scope.callRoute = function(route, async = 0, type = "get") {
            //Chama função global que chama uma rota ao clicar no botão
            $rootScope.callRouteRS(route, async, type, $scope);
        }

        $scope.clickRow = function(row, col, $event) {
            //Chama função global que manipula o click na linha do grid
            $rootScope.clickRowRS(row, col, $event, $scope, $animate, $compile, $timeout);
        }


       //Salva o grid atual em uma variavel de sessão e banco (ajax)
        $scope.saveState = function() {
            $rootScope.saveStateRS($scope, $http);
        };

        //Restaura o grid salvo em sessão ou banco (ajax)
        $scope.restoreState = function() {
            $rootScope.restoreStateRS($scope, $http);
        };

        //Carrega grid com os 2 mil ultimos documentos
        $scope.getFirstData = function() {
            $http({
                method: 'GET',
                url: '../../api/inventoryItems/'+ $scope.documentId + '/0'
            }).then(function(success) {
                $scope.gridOptions.data = success.data;
            }, function(error) {
                console.log("Errouuu" + error);
            });
        }

      
         //Entrada inicial seta document_id
        $scope.setDocument = function(id, number) {
            $scope.documentNumber = number;
            $scope.documentId = id;
        }



        //Esconde / Mostra os filtros
        $scope.toggleFiltering = function() {
            //Variavel de controle para buscar o filtro externo apenas uma vez
            $scope.hasFilter = false;
            $scope.gridOptions.enableFiltering = !$scope.gridOptions.enableFiltering;
            $scope.gridApi.core.notifyDataChange(uiGridConstants.dataChange.COLUMN);
        };

        //Alterna o agrupamento (barcode para endereço e vice versa)
        $scope.changeGrouping = function() {
           if($scope.group == 1){
                $scope.gridApi.grouping.clearGrouping();
                $scope.gridApi.grouping.groupColumn('Barcode');
                $scope.gridApi.grouping.aggregateColumn('Descrição', uiGridGroupingConstants.aggregation.MAX);
                $scope.gridApi.grouping.aggregateColumn('1ª Cont.', uiGridGroupingConstants.aggregation.SUM);
                $scope.group = 2;
           }else{
                $scope.gridApi.grouping.clearGrouping();
                $scope.gridApi.grouping.groupColumn('Endereço');
                $scope.gridApi.grouping.aggregateColumn('1ª Cont.', uiGridGroupingConstants.aggregation.SUM);
                $scope.group = 1;
           }
            
        };


        //Ajusta o layout depois que esconde / mostra o menu
        $("#button_menu").click(function() {
            $scope.gridApi.core.refresh();
        });


    }
]);


//Filtro para converter data
app.filter('dateFilter', function() {
    return function(value) {
        if (value) {
            return moment(value).format('DD/MM/YY');
        } else {
            return '';
        }
    };
})