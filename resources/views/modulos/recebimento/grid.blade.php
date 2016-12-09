@extends('layouts.app')

@section('content')
    <div class="row" >
        <div class="col-md-12 pad-ct">

            <div class="panel panel-default" ng-controller="MainCtrl" >
                <div class="panel-heading">
                    Módulo de Produção
                </div>
                <div class="row buttons_grid">
                    <a href="#" id="button_menu" data-toggle="modal" data-target="#ModalTeste"> 
                        <img class="icon_grid" src="<% asset('/icons/add.png') %>" alt="Adicionar">
                    </a>
                    <a href="#" id="button_menu"> 
                        <img class="icon_grid" src="<% asset('/icons/import.png') %>" alt="Importar">
                    </a>
                    <a href="#" id="toggleFiltering" ng-click="toggleFiltering()"> 
                        <img class="icon_grid" src="<% asset('/icons/filter.png') %>" alt="Filtrar">
                    </a>

                </div>
                 <div class="panel-body">
                    <table id="myTable" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Número</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th>Emissão</th>
                                <th>Cliente</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                         <tfoot>
                            <tr>
                                <th>Número</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th>Emissão</th>
                                <th>Cliente</th>
                                <th>Opções</th>
                            </tr>
                        </tfoot>
                    </table>
                    <button id="save" type="button" class="btn btn-success">Save</button>
                    <button id="restore" type="button" class="btn btn-success">Restore</button>
                 </div>
            </div>
            
        </div>
        
    </div>
    
@endsection
@section('scripts')
    <script>
    $( document ).ready(function() {

        $('#myTable tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
        } );

       var table =  $('#myTable').DataTable( {
                        colReorder: true,
                        stateSave: true,
                        "scrollX": true,
                        ajax: {
                            url: 'api/documentsProd',
                            dataSrc: ''
                        },
                        columns: [
                            {data: 'number', className: 'text-center'},
                            {data: 'document_type_code', className: 'text-center'},
                            {data: 'document_status_id', className: 'text-center'},
                            {data: 'emission_date', className: 'text-center'},
                            {data: 'customer_id', className: 'text-center'},
                            {data: null},
                            
                        ],
                        "createdRow": function ( row, data, index ) {
                                $('td', row).eq(1).html('<div class="grid_cell stat'+data['document_status_id']+'">'+data['document_status_id']+'</div>');
                        }
                    }); 
        table.columns().every( function () {
            var that = this;
    
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                }
            } );
        });

       console.log(table.state());

    });
    </script>
@endsection