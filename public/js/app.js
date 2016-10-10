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
var app = angular.module('grid_prod', ['ngTouch', 'ui.grid', 'ui.grid.selection','ui.grid.pagination', 'ui.grid.exporter']);

app.controller('MainCtrl', ['$scope','$http','uiGridConstants', function ($scope, $http, uiGridConstants) {
		
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
			exporterCsvFilename: 'myFile.csv',
			exporterPdfDefaultStyle: {fontSize: 9},
			exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
			exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
			exporterPdfHeader: { text: "My Header", style: 'headerStyle' },
		    columnDefs: [
		    { name: 'Número', field: 'number', headerCellClass: $scope.highlightFilteredHeader },
		    { name: 'Tipo', field: 'document_type_code' },
			{ name: 'Status', field: 'document_status_id',cellTemplate: '<div class="ui-grid-cell-contents"><div class="grid_cell stat{{grid.getCellValue(row, col)}}">{{grid.getCellValue(row, col)}}</div></div>' },
		    { name: 'Emissão', field: 'emission_date' },
      		{ name: 'Cliente', field: 'customer_id' }],
      		enablePaginationControls: false,
    		paginationPageSize: 18
      	};
		  
		//Carrega grid com os 3 mil ultimos documentos
        $http.get('http://localhost:81/AutologN/public/documents')
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

