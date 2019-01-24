//Geração dos Grids de Inventário
//Alteração das tags padrão do Angular de {{ }} para {% %}
var app = angular.module('grid_inv', ['ui.grid', 'ui.grid.selection',
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
                    $http.get('api/documents/090')
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
                display: 'description',
                filter: {
                    noTerm: true,
                    type: uiGridConstants.filter.SELECT,
                    selectOptions: [{ value: '0', label: 'Pendente' }, { value: '1', label: 'Liberado' }, { value: '2', label: 'Em execução' },
                        { value: '8', label: 'Encerrado' }, { value: '9', label: 'Cancelado' }
                    ]
                },
                cellTemplate: '<div class="ui-grid-cell-contents" ><div class="grid_cell stat{{grid.getCellValue(row, col)}}"> <p>{{row.entity.description}}</p></div></div>'
            },
            { name: 'Contagem', field: 'inv_description' },
            { name: 'Emissão', field: 'emission_date', type: 'date', cellFilter: "date:\'yyyy-MM-dd\'" },
            { name: 'Início', field: 'start_date', type: 'date', cellFilter: "date:\'yyyy-MM-dd\'" },
            { name: 'Finalização', field: 'end_date', type: 'date', cellFilter: "date:\'yyyy-MM-dd\'" },
            { name: 'Opções', cellTemplate: 'options' }
        ],
        enablePaginationControls: true,
        paginationPageSize: 25
    };

    //Função que chama as rotas do laravel
    $scope.callRoute = function(route) {
        window.location = route;
    }

    //Salva o grid atual em uma variavel de sessão e banco (ajax)
    $scope.saveState = function() {
        var datas = $scope.gridApi.saveState.save();
        localStorage.setItem('Autolog_GridInv', JSON.stringify(datas));
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
        var columns = localStorage.getItem('Autolog_GridInv');
        if (columns) {
            $scope.gridApi.saveState.restore($scope, JSON.parse(columns));
        } else {
            $http({
                method: 'GET',
                url: 'api/grid/Inventario'
            }).then(function(data) {
                $scope.gridApi.saveState.restore($scope, data);
            });
        }
    };

    //Carrega grid com os 2 mil ultimos documentos
    $scope.getFirstData = function() {
        $http({
            method: 'GET',
            url: 'api/documents/090/2000'
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
        onRegisterApi: function(gridApiDet) {
            $scope.gridApiDet = gridApiDet;
            $timeout(function() {
                $scope.restoreState();
            }, 50);
        },
        enableGridMenu: true,
        columnDefs: [
            { name: 'Item', field: 'product_code' },
            { name: 'Quantidade', field: 'qty' },
            { name: 'Unidade', field: 'uom_code' },
            { name: 'Lote', field: 'batch' },
            { name: 'Lote Fornec', field: 'batch_supplier' },
            { name: 'Qtd. Conf.', field: 'qty_conf' },
            { name: 'Qtd. Embarc.', field: 'qty_ship' },
            { name: 'Status', field: 'document_status_id', cellTemplate: '<div class="ui-grid-cell-contents"><div class="grid_cell stat{{grid.getCellValue(row, col)}}"><p>{{row.entity.description}}</p></div></div>' },
            { name: 'Opções', cellTemplate: 'options' }
        ],
        enablePaginationControls: false,
        paginationPageSize: 18
    };

    //Salva o grid atual em uma variavel de sessão e banco (ajax)
    $scope.saveState = function() {
        var datas = $scope.gridApiDet.saveState.save();
        localStorage.setItem('Autolog_GridInv_Det', JSON.stringify(datas));
        $http({
            method: 'POST',
            url: 'api/grid'
        }).then(function(data) {
            $scope.PostDataResponse = data;
        }, function(error) {
            console.log("Erro ao buscar Grid Salvo");
        });
    };

    $scope.restoreState = function() {
        var columns = localStorage.getItem('Autolog_GridInv_Det');
        //console.log(columns);
        if (columns) {
            $scope.gridApiDet.saveState.restore($scope, JSON.parse(columns));
        } else {
            $http({
                method: 'GET',
                url: 'api/grid/InventarioDet'
            }).then(function(data) {
                $scope.gridApiDet.saveState.restore($scope, data);
            });
        }
    };

    $scope.callRoute = function(route) {
        window.location = route;
    }

    //Carrega a tabela quando clicar nos detalhes do documento
    $scope.showGrid = function(id, number) {
        $scope.documentNumber = number;

        //Busca os itens do documento
        $http.get('../../api/documentItems/' + id)
            .then(function(response) {
                $scope.gridDetalhes.data = response.data;
            });
    }

    //Esconde / Mostra os filtros
    $scope.toggleFiltering = function() {
        $rootScope.gridDetalhes.enableFiltering = !$scope.gridDetalhes.enableFiltering;
        $rootScope.gridApiDet.core.notifyDataChange(uiGridConstants.dataChange.COLUMN);
    };


}])