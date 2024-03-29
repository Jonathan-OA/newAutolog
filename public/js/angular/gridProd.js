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

//Funções reaproveitadas no grid de documentos e no grid de itens ROWSCOOPE
app.run(['$rootScope', function($rootScope) {

    //Função que chama as rotas do laravel
    $rootScope.callRouteRS = function(route, async = 0, typeAjax = "get", $scope) {

        //$rootScope.page = documents: veio do grid de documentos
        //$rootScope.page = items : veio do grid de itens
        $scopeC = ($rootScope.page == 'documents') ? $scope.gridApi : $scope.gridApiDet;

        //Pega todos os documentos selecionados para mandar como post
        var documentsSelected = $scopeC.selection.getSelectedRows();

        //async = 1 executa a função da URL sem sair da tela
        if (async == 1) {

            //Token obrigatório para envio POST
            var tk = $('meta[name="csrf-token"]').attr('content');

            //.Ajax mostra o icone de loading automaticamente
            $.ajax({
                    type: typeAjax,
                    url: route,
                    data: { 'documents': documentsSelected, _token: tk }
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

            //Desabilita o modo Onda caso esteja ativado
            if ($scopeC.grid.options.multiSelect) $scope.toggleMultiSelect();

        } else {
            //Entra na rota passada por parâmetro
            window.location = route;
        }
    }

    //Ação ao clicar na linha do grid
    $rootScope.clickRowRS = function(row, col, $event, $scope, $animate, $compile, $timeout) {

        //$rootScope.page = documents: veio do grid de documentos
        //$rootScope.page = items : veio do grid de itens
        $scopeC = ($rootScope.page == 'documents') ? $scope.gridApi : $scope.gridApiDet;

        //Só mostra a lista de botões se não estiver no modo ONDA
        if (!$scopeC.grid.options.multiSelect) {

            //Limpa a linhas e Seleciona a linha clicada
            //if ($rootScope.page == 'documents') {
            $scopeC.selection.clearSelectedRows();
            // }
            row.isSelected = true;

            //Apaga outras caixas de botões que existirem
            $('#options').remove();
            //Passa todos os valores da linha selecionada para validação dos botões visíveis
            $scope.row = row.entity;
            $scope.row.status_inv = row.entity.inventory_status_id;
            $scope.row.status_doc = row.entity.document_status_id;
            //Pega id da ultima coluna
            var ultCol = $scopeC.grid.columns[$scopeC.grid.columns.length - 1].uid;
            var penultCol = $scopeC.grid.columns[$scopeC.grid.columns.length - 2].uid;
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
        } else {
            //Seleciona linha
            row.isSelected = !row.isSelected;
            //Atualiza qde de documentos selecionados na onda
            $scope.docsSelected = $scope.gridApi.selection.getSelectedRows().length;
        }

    }

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
app.controller('MainCtrl', ['$rootScope', '$scope', '$http', 'uiGridConstants', '$timeout', '$animate', '$compile', '$filter',
    function($rootScope, $scope, $http, uiGridConstants, $timeout, $animate, $compile, $filter) {
        //Código do grid a ser salvo / recuperado no banco
        $scope.gridCode = 'AUTOLOGWMS_GridProd';
        $scope.hasFilter = false;
        $scope.docsSelected = 0;
        $scope.clickFilter = 0;
        $rootScope.page = 'documents';
        $scope.gridOptions = {
            enableFullRowSelection: false,
            enableRowSelection: false,
            rowSelection: false,
            multiSelect: false,
            enableFiltering: false,
            fastWatch: true,
            enableColumnResizing: true,
            enableHorizontalScrollbar: true,
            onRegisterApi: function(gridApi) {
                $scope.gridApi = gridApi;
                $timeout(function() {
                    $scope.restoreState($scope.gridCode);
                }, 50);
                //Chama a função que preenche o grid
                $scope.getFirstData();
                //Caso o filtro não retorne nenhuma informação, busca todos os documentos (se não estiver no modo onda)
                $scope.gridApi.core.on.rowsRendered($scope, function() {
                    var qty_lines = $scope.gridApi.core.getVisibleRows($scope.gridApi.grid).length;

                    if (qty_lines == 0 && $scope.gridOptions.enableFiltering && !$scope.hasFilter && !$scope.gridApi.grid.options.multiSelect) {
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
                });
                //Cria função para evento de Scroll no grid.
                $scope.$watch('gridApi.grid.isScrollingVertically', function(newData) {
                    if (newData === true) {
                        $rootScope.$broadcast('scrolled');
                    }
                });
                //Quando seleciona uma linha, incrementa qde de documentos (onda)
                $scope.gridApi.selection.on.rowSelectionChanged($scope, function(rows) {
                    $scope.docsSelected = $scope.gridApi.selection.getSelectedRows().length;
                });
                //Quando seleciona todos, incrementa qde de documentos (onda)
                $scope.gridApi.selection.on.rowSelectionChangedBatch($scope, function(rows) {
                    $scope.docsSelected = $scope.gridApi.selection.getSelectedRows().length;
                });


            },
            enableGridMenu: true,
            columnDefs: [
                { name: 'Número', field: 'number', type: 'number', minWidth: 120 },
                { name: 'Tipo', field: 'document_type_code', width: 70, enableColumnResizing: false },
                {
                    name: 'Status',
                    field: 'document_status_id',
                    display: 'description',
                    minWidth: 150,
                    filter: {
                        noTerm: true,
                        type: uiGridConstants.filter.SELECT,
                        selectOptions: [{ value: '0', label: 'Pendente' }, { value: '1', label: 'Liberado' }, { value: '2', label: 'Em execução' },
                            { value: '8', label: 'Encerrado' }, { value: '9', label: 'Cancelado' }
                        ]
                    },
                    cellTemplate: '<div id="teste" class="ui-grid-cell-contents" ><div class="grid_cell stat{{grid.getCellValue(row, col)}}"> {{row.entity.description}}</div></div>'
                },
                { name: 'Itens', field: 'total_items', type: 'number', width: 70, enableColumnResizing: false },
                { name: 'Cliente', field: 'customer', minWidth: 220 },
                {
                    name: 'Produção',
                    field: 'total_conf',
                    minWidth: 110,
                    type: 'number',
                    cellTemplate: '<div class="ui-grid-cell-contents" ><div class="progress"><div class="progress-bar bg-success" role="progressbar" style="width: {{row.entity.total_conf}}%;max-width: 100% !important;" aria-valuenow="{{row.entity.total_conf}}" aria-valuemin="0" aria-valuemax="100">{{row.entity.total_conf}}%</div></div></div></div>'
                },
                { name: 'Onda', field: 'wave', minWidth: 150 },
                { name: 'Máquina', field: 'location_code', minWidth: 100 },
                { name: 'Emissão', field: 'emission_date', type: 'date', cellFilter: "dateFilter", minWidth: 100, enableColumnResizing: false },
                { name: 'Fin. Hab.', field: 'finalization', minWidth: 100, cellTemplate: '<div class="ui-grid-cell-contents" ><img ng-show="{{row.entity.finalization}}" class="icon" src="icons/checked.png"></div>' },
                { name: 'Transportadora', field: 'courier', minWidth: 220 },
                { name: 'Início', field: 'start_date', type: 'date', cellFilter: "dateFilterHr", minWidth: 130, enableColumnResizing: false },
                { name: 'Finalização', field: 'end_date', type: 'date', cellFilter: "dateFilterHr", minWidth: 130, enableColumnResizing: false }
            ],
            enablePaginationControls: true,
            paginationPageSizes: [40, 80, 120],
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

        //Carrega grid com os 3 mil ultimos documentos
        $scope.getFirstData = function() {
            $http({
                method: 'GET',
                url: 'api/documents/030/3000'
            }).then(function(success) {
                $scope.gridOptions.data = success.data;
            }, function(error) {
                alert('Erro ao carregar Grid. Tente novamente')
                console.log("Errouuu" + error);
            });
        }

        //Função que habilita multipla seleção (Onda / Campanha)
        $scope.toggleMultiSelect = function() {
            $('#testemicrotip').trigger('hover');
            $('#wave_grid').toggle();
            $scope.docsSelected = 0;
            $scope.clickFilter = 0;
            $scope.gridApi.grid.refresh();

            //Limpa as linhas selecionadas
            $scope.gridApi.selection.clearSelectedRows();

            //Limpa todos os filtros
            $scope.gridApi.grid.clearAllFilters();

            //Habilita / Desabilita multiselect
            $scope.gridApi.selection.setMultiSelect(!$scope.gridApi.grid.options.multiSelect);

            //Se esta ativando o botão, filtra por documentos pendentes na tela
            if ($scope.gridApi.grid.options.multiSelect) {
                $scope.gridOptions.enableFiltering = true;
                $scope.gridApi.grid.columns[3].filters[0].term = 0;
                console.log($scope.gridApi.grid.columns[3]);
                $('#options').remove(); //Fecha caixa com botões se houver alguma aberta
            } else {
                $scope.gridOptions.enableFiltering = false;
                $scope.gridApi.grid.columns[3].filters[0].term = '';
            }

        }


        //Esconde / Mostra os filtros
        $scope.toggleFiltering = function() {

            $scope.clickFilter = !$scope.clickFilter;
            //Limpa as linhas selecionadas
            $scope.gridApi.selection.clearSelectedRows();

            if (!$scope.gridApi.grid.options.multiSelect) {
                //Limpa o filtro caso exista e a Onda não esteja ativada
                $scope.gridApi.grid.columns[3].filters[0].term = '';
                $scope.gridOptions.enableFiltering = !$scope.gridOptions.enableFiltering;
                $scope.gridApi.core.notifyDataChange(uiGridConstants.dataChange.COLUMN);
            } else {
                $scope.gridApi.grid.columns[3].enableFiltering = false;
                $scope.gridApi.core.notifyDataChange(uiGridConstants.dataChange.COLUMN);
                if (!$scope.clickFilter) {
                    $scope.gridOptions.enableFiltering = !$scope.gridOptions.enableFiltering;
                    $scope.gridApi.grid.columns[3].filters[0].term = 0;

                    $scope.gridApi.core.notifyDataChange(uiGridConstants.dataChange.COLUMN);
                    $scope.gridOptions.enableFiltering = !$scope.gridOptions.enableFiltering;
                }
            }
            $scope.hasFilter = false;

        };

        //Ajusta o layout depois que esconde / mostra o menu
        $("#button_menu").click(function() {
            $scope.gridApi.core.refresh();
        });
    }
]);
//Grid de detalhes dos documentos
app.controller('DetCtrl', ['$rootScope', '$scope', '$http', 'uiGridConstants', '$timeout', '$animate', '$compile', '$filter',
    function($rootScope, $scope, $http, uiGridConstants, $timeout, $animate, $compile, $filter) {
        //Código do grid a ser salvo / recuperado no banco
        $scope.gridCode = 'AUTOLOGWMS_GridProd_Det';
        $scope.gridDetalhes = {};
        $scope.gridDetalhes.data = [];
        $rootScope.page = 'items';
        $scope.gridDetalhes = {
            enableRowSelection: false,
            rowSelection: true,
            enableFullRowSelection: false,
            multiSelect: false,
            enableFiltering: false,
            fastWatch: true,
            onRegisterApi: function(gridApiDet) {
                $scope.gridApiDet = gridApiDet;
                $timeout(function() {
                    $scope.restoreState($scope.gridCode);
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
                { name: 'Status', field: 'document_status_id', cellTemplate: '<div class="ui-grid-cell-contents"><div class="grid_cell stat{{grid.getCellValue(row, col)}}">{{row.entity.description}}</div></div>' }
            ],
            enablePaginationControls: false,
            paginationPageSize: 18,
            rowTemplate: '<div ng-click="grid.appScope.clickRow(row, col, $event)" ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.uid" class="ui-grid-cell" ng-class="col.colIndex()" ui-grid-cell></div>',
        };

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

        //Ajusta o layout depois que esconde / mostra o menu
        $("#button_menu").click(function() {
            $scope.gridApi.core.refresh();
        });
    }
])

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

//Filtro para converter data e hora
app.filter('dateFilterHr', function() {
    return function(value) {
        if (value) {
            return moment(value).format('DD/MM/YY hh:mm');
        } else {
            return '';
        }
    };
})