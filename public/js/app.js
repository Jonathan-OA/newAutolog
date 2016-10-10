//Funções Relacionadas ao Layout Base
$( document ).ready(function() {
    //Esconde / Mostra Menu
    $('#button_menu').click(function(){
        $('#lay_menu_op').toggle();
        if ($('#lay_menu_op').is(':visible')){
            $(this).css('menu');
        }
    })

});

//Geração dos Grids
var app = angular.module('grid_prod', ['ngTouch', 'ui.grid', 'ui.grid.selection',
									   'ui.grid.pagination','ui.grid.saveState',
									   'ui.grid.moveColumns']);

app.controller('MainCtrl', ['$scope','$http', function ($scope, $http) {
		
		$scope.highlightFilteredHeader = function( row, rowRenderIndex, col, colRenderIndex ) {
		    if( col.filters[0].term ){
		      return 'header-filtered';
		    } else {
		      return '';
		    }
		  };

		$scope.gridOptions = {
			enableFiltering: false,
			fastWatch: true,
			onRegisterApi: function(gridApi){
				$scope.gridApi = gridApi;
			},
			enableGridMenu: true,
		    columnDefs: [
		    { name: 'Número', field: 'number', headerCellClass: $scope.highlightFilteredHeader },
		    { name: 'Tipo', field: 'document_type_code' },
			{ name: 'Status', field: 'document_status_id',cellTemplate: '<div class="ui-grid-cell-contents"><div class="grid_cell stat{{grid.getCellValue(row, col)}}">{{grid.getCellValue(row, col)}}</div></div>' },
		    { name: 'Emissão', field: 'emission_date' },
      		{ name: 'Cliente', field: 'customer_id' }],
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
			console.log(columns);
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

