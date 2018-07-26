//Geração dos Grids de Produção
//Alteração das tags padrão do Angular de {{ }} para {% %}
var app = angular.module('grid_prod', ['ui.grid', 'ui.grid.selection',
    'ui.grid.pagination', 'ui.grid.saveState',
    'ui.grid.moveColumns', 'ui.grid.autoResize',
    'ui.grid.resizeColumns', 'ui.grid.exporter'
], function($interpolateProvider) {
    $interpolateProvider.startSymbol('{%');
    $interpolateProvider.endSymbol('%}');
});

//Config pra remover erros inuteis
app.config(['$qProvider', function($qProvider) {
    $qProvider.errorOnUnhandledRejections(false);
}]);



//Grid de documentos
app.controller('MainCtrl', ['$rootScope', '$scope', '$http', 'uiGridConstants', '$timeout', '$element', function($rootScope, $scope, $http, uiGridConstants, $timeout, $element) {
    $scope.hasFilter = false;
    $scope.gridOptions = {
        enableFullRowSelection: false,
        multiSelect: false,
        enableFiltering: false,
        fastWatch: true,
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
            $timeout(function() {
                $scope.restoreState();
            }, 50);
            //Chama a função que preenche o grid
            $scope.getFirstData();
            //Caso o filtro não retorne nenhuma informação, busca todos os documentos
            $scope.gridApi.core.on.rowsRendered($scope, function() {
                var qty_lines = $scope.gridApi.core.getVisibleRows($scope.gridApi.grid).length;

                if (qty_lines == 0 && $scope.gridOptions.enableFiltering && !$scope.hasFilter) {
                    //Variavel de controle para buscar o filtro externo apenas uma vez
                    $scope.hasFilter = true;
                    //Busca os dados novamente sem filtro de quantidade
                    $http.get('api/documents/030')
                        .then(function(response) {
                            $scope.gridOptions.data = response.data;
                        });
                } else {
                    $scope.hasFilter = false;
                }
            })
        },
        enableGridMenu: true,
        columnDefs: [
            { name: 'Número', field: 'number' },
            { name: 'Tipo', field: 'document_type_code' },
            {
                name: 'Status',
                field: 'document_status_id',
                filter: {
                    noTerm: true,
                    type: uiGridConstants.filter.SELECT,
                    selectOptions: [{ value: '0', label: 'Pendente' }, { value: '1', label: 'Liberado' }, { value: '2', label: 'Em execução' }]
                },
                cellTemplate: '<div class="ui-grid-cell-contents"><div class="grid_cell stat{{grid.getCellValue(row, col)}}">{{grid.getCellValue(row, col)}}</div></div>'
            },
            { name: 'Emissão', field: 'emission_date' },
            { name: 'Cliente', field: 'customer_code' },
            { name: 'Opções', cellTemplate: 'options' }
        ],
        enablePaginationControls: true,
        paginationPageSize: 25
    };

    //Função que chama as rotas do laravel
    $scope.callRoute = function(route) {
        window.location = route;
    }

    $scope.showGridDet = function(id, number) {
        $rootScope.showGrid(id, number);
    }

    //Salva o grid atual em uma variavel de sessão e banco (ajax)
    $scope.saveState = function() {
        var datas = $scope.gridApi.saveState.save();
        localStorage.setItem('Autolog_GridProd', JSON.stringify(datas));
        $http({
            method: 'POST',
            url: 'api/grid'
        }).then(function(data) {
            $scope.PostDataResponse = data;
        }, function(error) {
            console.log("Erro ao buscar Grid Salvo");
        });
    };

    //Restaura o grid salvo em sessão ou banco (ajax)
    $scope.restoreState = function() {
        var columns = localStorage.getItem('Autolog_GridProd');
        if (columns) {
            $scope.gridApi.saveState.restore($scope, JSON.parse(columns));
        } else {
            $http({
                method: 'GET',
                url: 'api/grid/Produção'
            }).then(function(data) {
                $scope.gridApi.saveState.restore($scope, data);
            });
        }
    };

    //Carrega grid com os 2 mil ultimos documentos
    $scope.getFirstData = function() {
        $http({
            method: 'GET',
            url: 'api/documents/030/2000'
        }).then(function(success) {
            $scope.gridOptions.data = success.data;
        }, function(error) {
            console.log("Errouuu" + error);
        });
    }


    //Esconde / Mostra os filtros
    $scope.toggleFiltering = function() {
        $scope.hasFilter = false;
        $scope.gridOptions.enableFiltering = !$scope.gridOptions.enableFiltering;
        $scope.gridApi.core.notifyDataChange(uiGridConstants.dataChange.COLUMN);
    };

    //Carrega botões para o documento
    /*
    $scope.showActions = function(modulo, id) {
        $.get('getButtons/' + modulo, function(data) {
            //Remove a div gerada anteriormente (caso exista)
            $('#div_buttons').remove();
            //Carrega os botões
            var tp = $('#listButtons' + id).position().top;
            var lp = $('#listButtons' + id).position().left - 40;
            //alert($('#lay_header').width());
            $('#listButtons' + id).before('<span class="options" name="options" onmouseleave="" style="position: absolute;  left: ' + lp + 'px; ";>' + data + '</span>');

            //console.log($('#listButtons' + id).position());
        })
    };
    */
}]);

//Grid de detalhes dos documentos
app.controller('DetCtrl', ['$rootScope', '$scope', '$http', 'uiGridConstants', '$timeout', '$interval', function($rootScope, $scope, $http, uiGridConstants, $timeout, $interval) {
    $scope.gridDetalhes = {};
    $scope.gridDetalhes.data = [];
    $scope.gridDetalhes = {
        enableFullRowSelection: false,
        multiSelect: false,
        enableFiltering: false,
        fastWatch: true,
        enableGridMenu: true,
        columnDefs: [
            { name: 'Item', field: 'product_code' },
            { name: 'Unidade', field: 'uom_code' },
            { name: 'Quantidade', field: 'qty' },
            { name: 'Status', field: 'document_status_id', cellTemplate: '<div class="ui-grid-cell-contents"><div class="grid_cell stat{{grid.getCellValue(row, col)}}">{{grid.getCellValue(row, col)}}</div></div>' },
            { name: 'Opções', cellTemplate: 'options' }
        ],
        enablePaginationControls: false,
        paginationPageSize: 18
    };

    $scope.saveState = function() {
        var datas = $scope.gridApiDet.saveState.save();
        localStorage.setItem('Autolog_GridProdDet', JSON.stringify(datas));
        $http.post('../../api/grid', datas)
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
            $http.get('../../api/grid/Produção')
                .success(function(data) {
                    $scope.gridApiDet.saveState.restore($scope, data);
                })
        }
    };

    $scope.callRoute = function(route) {
        window.location = route;
    }

    //Carrega a tabela quando clicar nos detalhes do documento
    $scope.showGrid = function(id, number) {
        console.log(id);
        $scope.documentNumber = number;

        //Busca os dados
        $http.get('../../api/itemsProd/' + id)
            .then(function(response) {
                $scope.gridDetalhes.data = response.data;
            });
    }

    //Função que chama as rotas do laravel
    $scope.resetGrid = function() {
        console.log('aeeee');
    }


    //Esconde / Mostra os filtros
    $scope.toggleFiltering = function() {
        $rootScope.gridDetalhes.enableFiltering = !$scope.gridDetalhes.enableFiltering;
        $rootScope.gridApiDet.core.notifyDataChange(uiGridConstants.dataChange.COLUMN);
    };


}])