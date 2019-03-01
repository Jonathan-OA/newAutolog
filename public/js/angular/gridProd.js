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

//Funções reaproveitadas no grid de documentos e no grid de itens
app.run(['$rootScope', function($rootScope) {

    //Função que chama as rotas do laravel
    $rootScope.callRouteRS = function(route, async = 0, $scope) {
        //async = 1 executa a função da URL sem sair da tela
        if (async == 1) {
            //.Ajax mostra o icone de loading automaticamente
            $.ajax({
                    url: route
                })
                .done(function(data) {
                    //Mostra mensagem de sucesso ou erro
                    $('.alert').remove();
                    $('#msg_excluir').html('<div class="alert alert-' + data[0] + '">' + data[1] + '</div>');
                    $('.alert').html(data[1]);

                    //Carrega novamente o grid 
                    $scope.getFirstData();
                })
                .fail(function() {
                    alert("Erro ao Acessar Função");
                });

            //Apaga outras caixas de botões que existirem
            $('#options').remove();
        } else {
            //Entra na rota passada por parâmetro
            window.location = route;
        }
    }

    //Ação ao clicar na linha do grid
    $rootScope.clickRowRS = function(row, col, $event, $scope, $animate, $compile, $timeout) {
        //Apaga outras caixas de botões que existirem
        $('#options').remove();
        //Passa todos os valores da linha selecionada para validação dos botões visíveis
        $scope.row = row.entity;
        $scope.row.status_inv = row.entity.inventory_status_id;
        $scope.row.status_doc = row.entity.document_status_id;
        //Pega id da ultima coluna
        var ultCol = $scope.gridApi.grid.columns[$scope.gridApi.grid.columns.length - 1].uid;
        var penultCol = $scope.gridApi.grid.columns[$scope.gridApi.grid.columns.length - 2].uid;
        //Pega posição a esquerda do elemento clicado
        var left = $($event.currentTarget).position().left;
        if (col.uid != ultCol && col.uid != penultCol) {
            //Se não for ultima/penúltima coluna do grid, adiciona a direita
            left += $event.currentTarget.clientWidth;
        } else {
            left -= $event.currentTarget.clientWidth;
        }
        //Adiciona elemento que chama o template criado (buttonsDoc.blade.php)
        var element = angular.element("<div ng-include=\"'tplButtons'\"></div>");
        //Elemento que contem os botões
        var container = angular.element('<div class="options" id="options" style="position: absolute;  left: ' + left + 'px; " ></div>');
        $($event.currentTarget).after(container);
        //Insere o elemento no container e compila no DOM da página
        $animate.enter(element, container);
        $compile(element)($scope);
        $timeout(function() {
            $scope.$apply();
        }, 0)

    }

    //Salva grid modificado
    $rootScope.saveStateRS = function($scope, name, $http) {
        var datas = $scope.gridApi.saveState.save();
        localStorage.setItem(name, JSON.stringify(datas));
        $http({
            method: 'POST',
            url: 'api/grid'
        }).then(function(data) {
            $scope.PostDataResponse = data;
        }, function(error) {
            console.log("Erro ao buscar Grid Salvo");
        });
    }

    //Restaura grid salvo anteriormente
    $rootScope.restoreStateRS = function($scope, name, $http) {
        var columns = localStorage.getItem(name);
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
    }

}]);



//Grid de documentos
app.controller('MainCtrl', ['$rootScope', '$scope', '$http', 'uiGridConstants', '$timeout', '$animate', '$compile', '$filter',
    function($rootScope, $scope, $http, uiGridConstants, $timeout, $animate, $compile, $filter) {
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
                { name: 'Emissão', field: 'emission_date', type: 'date', cellFilter: "date:\'yyyy-MM-dd\'" },
                { name: 'Cliente', field: 'customer_code' },
                { name: 'Fornecedor', field: 'supplier_code' },
                { name: 'Transportadora', field: 'courier_code' },
                { name: 'Data Encerramento', field: 'end_date' }
            ],
            enablePaginationControls: true,
            paginationPageSize: 25,
            rowTemplate: '<div ng-click="grid.appScope.clickRow(row, col, $event)" ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.uid" class="ui-grid-cell" ng-class="col.colIndex()" ui-grid-cell></div>',

        };

        $scope.callRoute = function(route, async = 0) {
            //Chama função global que chama uma rota ao clicar no botão
            $rootScope.callRouteRS(route, async, $scope);
        }

        $scope.clickRow = function(row, col, $event) {
            //Chama função global que manipula o click na linha do grid
            $rootScope.clickRowRS(row, col, $event, $scope, $animate, $compile, $timeout);
        }


        //Salva o grid atual em uma variavel de sessão e banco (ajax)
        $scope.saveState = function(name) {
            $rootScope.saveStateRS($scope, name, $http);
        };

        //Restaura o grid salvo em sessão ou banco (ajax)
        $scope.restoreState = function(name) {
            $rootScope.restoreStateRS($scope, name, $http);
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
    }
]);

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

    $scope.callRoute = function(route, async = 0) {
        //Chama função global que chama uma rota ao clicar no botão
        $rootScope.callRouteRS(route, async, $scope);
    }

    $scope.clickRow = function(row, col, $event) {
        //Chama função global que manipula o click na linha do grid
        $rootScope.clickRowRS(row, col, $event, $scope, $animate, $compile, $timeout);
    }


    //Salva o grid atual em uma variavel de sessão e banco (ajax)
    $scope.saveState = function(name) {
        $rootScope.saveStateRS($scope, name, $http);
    };

    //Restaura o grid salvo em sessão ou banco (ajax)
    $scope.restoreState = function(name) {
        $rootScope.restoreStateRS($scope, name, $http);
    };

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