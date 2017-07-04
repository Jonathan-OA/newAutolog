//Geração dos Grids de Produção
var app = angular.module('grid_prod', ['ui.grid', 'ui.grid.selection',
    'ui.grid.pagination', 'ui.grid.saveState',
    'ui.grid.moveColumns', 'ui.grid.autoResize',
    'ui.grid.resizeColumns', 'ui.grid.exporter'
]);

//Grid de documentos
app.controller('MainCtrl', ['$rootScope', '$scope', '$http', 'uiGridConstants', '$timeout', '$element', function($rootScope, $scope, $http, uiGridConstants, $timeout, $element) {

    $scope.gridOptions = {
        enableFullRowSelection: false,
        multiSelect: false,
        enableFiltering: false,
        fastWatch: true,
        exporterCsvFilename: 'myFile.csv',
        exporterPdfDefaultStyle: { fontSize: 9 },
        exporterPdfTableStyle: { margin: [30, 30, 30, 30] },
        exporterPdfTableHeaderStyle: { fontSize: 10, bold: true, italics: true, color: 'red' },
        exporterPdfHeader: { text: "My Header", style: 'headerStyle' },
        exporterPdfFooter: function(currentPage, pageCount) {
            return { text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle' };
        },
        exporterPdfCustomFormatter: function(docDefinition) {
            docDefinition.styles.headerStyle = { fontSize: 22, bold: true };
            docDefinition.styles.footerStyle = { fontSize: 10, bold: true };
            return docDefinition;
        },
        exporterPdfOrientation: 'portrait',
        exporterPdfPageSize: 'LETTER',
        exporterPdfMaxGridWidth: 500,
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
            $timeout(function() {
                $scope.restoreState();
            }, 50);
        },
        enableGridMenu: true,
        columnDefs: [
            { name: 'Número', field: 'number' },
            { name: 'Tipo', field: 'document_type_code' },
            {
                name: 'Status',
                field: 'document_status_id',
                filter: {
                    term: '1',
                    type: uiGridConstants.filter.SELECT,
                    selectOptions: [{ value: '1', label: 'Liberado' }, { value: '2', label: 'Em execução' }, { value: '0', label: 'Pendente' }]
                },
                cellTemplate: '<div class="ui-grid-cell-contents"><div class="grid_cell stat{{grid.getCellValue(row, col)}}">{{grid.getCellValue(row, col)}}</div></div>'
            },
            { name: 'Emissão', field: 'emission_date' },
            { name: 'Cliente', field: 'customer_id' },
            { name: 'Opções', cellTemplate: 'options' }
        ],
        enablePaginationControls: true,
        paginationPageSize: 25
    };

    $scope.showGridDet = function(id, number) {
        $rootScope.showGrid(id, number);
    }

    $scope.saveState = function() {
        var datas = $scope.gridApi.saveState.save();
        localStorage.setItem('Autolog_GridProd', JSON.stringify(datas));
        $http.post('api/grid', datas)
            .success(function(data, status, headers, config) {
                $scope.PostDataResponse = data;
            }).error(function(data, status, header, config) {
                console.log('Erro ao Buscar Grid Salvo');
            });
    };


    $scope.restoreState = function() {
        var columns = localStorage.getItem('Autolog_GridProd');
        //console.log(columns);
        if (columns) {
            $scope.gridApi.saveState.restore($scope, JSON.parse(columns));
        } else {
            $http.get('api/grid/Produção')
                .success(function(data) {
                    $scope.gridApi.saveState.restore($scope, data);
                })
        }
    };

    //Carrega grid com os 3 mil ultimos documentos
    $http.get('api/documentsProd')
        .success(function(data) {
            $scope.gridOptions.data = data;
        })
        .error(function(data, status, headers, config) {
            console.log("Errouuu");
        });
    //Esconde / Mostra os filtros
    $scope.toggleFiltering = function() {
        $scope.gridOptions.enableFiltering = !$scope.gridOptions.enableFiltering;
        $scope.gridApi.core.notifyDataChange(uiGridConstants.dataChange.COLUMN);
    };

    //Carrega botões para o documento
    $scope.showActions = function(modulo, id) {
        $.get('getButtons/' + modulo, function(data) {
            //Remove a div gerada anteriormente (caso exista)
            $('#div_buttons').remove();
            //Carrega os botões
            $element.append(data);
        })
    };
}]);

//Grid de detalhes dos documentos
app.controller('DetCtrl', ['$rootScope', '$scope', '$http', 'uiGridConstants', '$timeout', '$interval', function($rootScope, $scope, $http, uiGridConstants, $timeout, $interval) {
    $scope.gridDetalhes = {};
    $scope.gridDetalhes.data = [];
    $scope.gridDetalhes = {
        enableFullRowSelection: true,
        multiSelect: false,
        enableFiltering: false,
        fastWatch: true,
        enableGridMenu: true,
        columnDefs: [
            { name: 'Item', field: 'item_code' },
            { name: 'Unidade', field: 'uom_code' },
            { name: 'Quantidade', field: 'qty' },
            { name: 'Status', field: 'status', cellTemplate: '<div class="ui-grid-cell-contents"><div class="grid_cell stat{{grid.getCellValue(row, col)}}">{{grid.getCellValue(row, col)}}</div></div>' },
            { name: 'Opções', cellTemplate: 'options' }
        ],
        enablePaginationControls: false,
        paginationPageSize: 18
    };

    $scope.saveState = function() {
        var datas = $scope.gridApiDet.saveState.save();
        localStorage.setItem('Autolog_GridProdDet', JSON.stringify(datas));
        $http.post('api/grid', datas)
            .success(function(data, status, headers, config) {
                $scope.PostDataResponse = data;
            }).error(function(data, status, header, config) {
                console.log('Erro ao Buscar Grid Salvo');
            });
    };

    $scope.restoreState = function() {
        var columns = localStorage.getItem('Autolog_GridProdDet');
        //console.log(columns);
        if (columns) {
            $scope.gridApiDet.saveState.restore($scope, JSON.parse(columns));
        } else {
            $http.get('api/grid/Produção')
                .success(function(data) {
                    $scope.gridApiDet.saveState.restore($scope, data);
                })
        }
    };

    $rootScope.showGrid = function(id, number) {
        $scope.documentNumber = number;

        $scope.gridDetalhes.data = [];

        $scope.gridDetalhes.onRegisterApi = function(gridApi) {
            $scope.gridApiDet = gridApi;
        }

        $http.get('api/itemsProd/' + id)
            .success(function(data) {
                $scope.gridDetalhes.data = data;
                $scope.dataLoaded = true;
            })
            .error(function(data, status, headers, config) {
                console.log("Errouuu kk");
            });
    }

    //Esconde / Mostra os filtros
    $scope.toggleFiltering = function() {
        $rootScope.gridDetalhes.enableFiltering = !$scope.gridDetalhes.enableFiltering;
        $rootScope.gridApiDet.core.notifyDataChange(uiGridConstants.dataChange.COLUMN);
    };


}]);