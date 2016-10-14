//Geração dos Grids de Produção
var app = angular.module('grid_prod', ['ui.grid', 'ui.grid.selection',
									   'ui.grid.pagination','ui.grid.saveState',
									   'ui.grid.moveColumns']);
//Grid de documentos
app.controller('MainCtrl', ['$scope','$http','uiGridConstants','$timeout', function ($scope, $http, uiGridConstants, $timeout) {

	$(function() {
		$('#hhhaaa').click(function(){
			alert('hue');
		})
	});

		$scope.gridOptions = {
			enableFullRowSelection: true,
			multiSelect: false,
			enableFiltering: false,
			fastWatch: true,
			onRegisterApi: function(gridApi){
				$scope.gridApi = gridApi;
				//Função executada ao selecionar uma linha no grid
				gridApi.selection.on.rowSelectionChanged($scope,function(row){
					console.log(row);
				});
				$timeout(function(){
					$scope.restoreState();
				},50);
			},
			enableGridMenu: true,
		    columnDefs: [
		    { name: 'Número', field: 'number' },
		    { name: 'Tipo', field: 'document_type_code' },
			{ name: 'Status', field: 'document_status_id',cellTemplate: '<div class="ui-grid-cell-contents"><div class="grid_cell stat{{grid.getCellValue(row, col)}}">{{grid.getCellValue(row, col)}}</div></div>' },
		    { name: 'Emissão', field: 'emission_date' },
      		{ name: 'Cliente', field: 'customer_id' },
			{ name: 'Opções', cellTemplate: 'options'}],
      		enablePaginationControls: false,
    		paginationPageSize: 18
      	};

		$scope.saveState = function() {
			var datas = $scope.gridApi.saveState.save();
			localStorage.setItem('Autolog_GridProd', JSON.stringify(datas));
			$http.post('http://localhost/AutologN/public/api/grid', datas)
            .success(function (data, status, headers, config) {
                $scope.PostDataResponse = data;
            }).error(function (data, status, header, config) {
               console.log('Erro ao Buscar Grid Salvo');
            });
		};
		
		$scope.restoreState = function() {
			var columns = localStorage.getItem('Autolog_GridProd');
			//console.log(columns);
			if (columns) {
				$scope.gridApi.saveState.restore( $scope, JSON.parse(columns) );
			}else{
				$http.get('http://localhost/AutologN/public/api/grid/Produção')
				.success(function (data) {
					$scope.gridApi.saveState.restore( $scope, data );
				})
			}
		};

		//Carrega grid com os 3 mil ultimos documentos
        $http.get('http://localhost/AutologN/public/api/documentsProd')
         .success(function (data) {
             $scope.gridOptions.data = data;
         })
         .error(function (data, status, headers, config) {
             console.log("Errouuu");
         });
		 //Esconde / Mostra os filtros
		 $scope.toggleFiltering = function(){
			$scope.gridOptions.enableFiltering = !$scope.gridOptions.enableFiltering;
			$scope.gridApi.core.notifyDataChange( uiGridConstants.dataChange.COLUMN );
		};

}]);

//Grid de documentos
app.controller('DetCtrl', ['$scope','$http','uiGridConstants','$timeout','$window', function ($scope, $http, uiGridConstants, $timeout, $window) {
		$scope.gridOptions = {
			enableFullRowSelection: true,
			multiSelect: false,
			enableFiltering: false,
			fastWatch: true,
			onRegisterApi: function(gridApi){
				$scope.gridApi = gridApi;
				//Função executada ao selecionar uma linha no grid
				gridApi.selection.on.rowSelectionChanged($scope,function(row){
					console.log(row);
				});
				$timeout(function(){
					$scope.restoreState();
				},50);
			},
			enableGridMenu: true,
		    columnDefs: [
		    { name: 'Item', field: 'item_code' },
		    { name: 'Unidade', field: 'uom_code' },
			{ name: 'Quantidade', field: 'qty' },
			{ name: 'Status', field: 'document_status_id',cellTemplate: '<div class="ui-grid-cell-contents"><div class="grid_cell stat{{grid.getCellValue(row, col)}}">{{grid.getCellValue(row, col)}}</div></div>' },
		    { name: 'Opções', cellTemplate: 'options'}],
      		enablePaginationControls: false,
    		paginationPageSize: 18
      	};

		$scope.saveState = function() {
			var datas = $scope.gridApi.saveState.save();
			localStorage.setItem('Autolog_GridProdDet', JSON.stringify(datas));
			$http.post('http://localhost/AutologN/public/api/grid', datas)
            .success(function (data, status, headers, config) {
                $scope.PostDataResponse = data;
            }).error(function (data, status, header, config) {
               console.log('Erro ao Buscar Grid Salvo');
            });
		};
		
		$scope.restoreState = function() {
			var columns = localStorage.getItem('Autolog_GridProdDet');
			//console.log(columns);
			if (columns) {
				$scope.gridApi.saveState.restore( $scope, JSON.parse(columns) );
			}else{
				$http.get('http://localhost/AutologN/public/api/grid/Produção')
				.success(function (data) {
					$scope.gridApi.saveState.restore( $scope, data );
				})
			}
		};
		//Pega o valor da variavel que foi definido na view
		$scope.$watch("document_id", function(){
			//Carrega grid com os 3 mil ultimos documentos
			$http.get('http://localhost/AutologN/public/api/itemsProd/'+$scope.document_id)
			.success(function (data) {
				$scope.gridOptions.data = data;
			})
			.error(function (data, status, headers, config) {
				console.log("Errouuu");
			});
			//Esconde / Mostra os filtros
			$scope.toggleFiltering = function(){
				$scope.gridOptions.enableFiltering = !$scope.gridOptions.enableFiltering;
				$scope.gridApi.core.notifyDataChange( uiGridConstants.dataChange.COLUMN );
			};
		});

		

}]);

