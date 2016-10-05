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
var app = angular.module('app', ['ngTouch', 'ui.grid', 'ui.grid.selection', 'ui.grid.expandable','ui.grid.pagination']);

app.controller('MainCtrl', ['$scope','$http', function ($scope, $http) {

		$scope.highlightFilteredHeader = function( row, rowRenderIndex, col, colRenderIndex ) {
		    if( col.filters[0].term ){
		      return 'header-filtered';
		    } else {
		      return '';
		    }
		  };

		$scope.gridOptions = {
			enableFiltering: true,
			fastWatch: true,
		    columnDefs: [
		    { field: 'numero', headerCellClass: $scope.highlightFilteredHeader },
		    { field: 'tipo' },
		    { field: 'status', cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
										            return 'stat'+grid.getCellValue(row,col);
										           }},
		    { field: 'emissao' },
      		{ field: 'clifor' }],
      		enablePaginationControls: false,
    		paginationPageSize: 18,
      		expandableRowTemplate: 'docitm.html',
			expandableRowHeight: 150
	        
      	};

		//Carrega grid com os 3 mil ultimos documentos
        $http.get('http://localhost:81/WebService/grid')
         .success(function (data) {
             for(i = 0; i < data.length; i++){

	            data[i].subGridOptions = {
	              columnDefs: [ {name:"Id", field:"num"},{name:"Name", field:"nome"} ],
	              data: data[i].itens
	            }
	          }
             $scope.gridOptions.data = data;
         })
         .error(function (data, status, headers, config) {
             console.log("Errouuu");
         });

}]);
