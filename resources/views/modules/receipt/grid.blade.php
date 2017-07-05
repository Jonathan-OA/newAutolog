@extends('layouts.app')

@section('content')
    <div class="row" >
        <div class="col-md-12 pad-ct">
            <div id="ModalTeste" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" >
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Módulo de Recebimento - Documento:
                            </div>
                            <div class="panel-body">
                                <div ui-grid="gridDetalhes"  class="grid" ></div>
                                    <button id="save" type="button" class="btn btn-success" ng-click="saveState()">Save</button>
                                    <button id="restore" type="button" class="btn btn-success" ng-click="restoreState()">Restore</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                 
            <div class="panel panel-default"  >
                <div class="panel-heading">
                    Módulo de Recebimento
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
                            {data: 'number', className: 'text-center',},
                            {data: 'document_type_code', className: 'text-center'},
                            {data: 'document_status_id', className: 'text-center'},
                            {data: 'emission_date', className: 'text-center'},
                            {data: 'customer_id', className: 'text-center'},
                            {defaultContent: '<div class="teste"> </div>' },             
                        ],         
        }); 
        //Ativa Filtros
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

    });
    </script>
@endsection