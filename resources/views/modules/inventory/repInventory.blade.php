@extends('layouts.app')

@section('content')
     <!-- BreadCrumb - Trilha  -->
     <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{!! route('inventory.index') !!}">@lang('models.inventory')</a></li>
              <li class="breadcrumb-item active" aria-current="page">@lang('models.reports')</li>
            </ol>
          </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel pbread panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('reports.reportInv') 
                </div>
                <div class="panel pbread panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Alerta de erro / sucesso -->
                            @include('flash::message')
                            <div id="msg_excluir"></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 pad-ct">
                                        <div class="" style="margin: 0 15px 0 15px">
                                        <table class="table table-bordered table-striped" id="relInv-table" cellspacing="0" width="100%">
                                            <thead>
                                                <th class="th_grid">@lang('models.deposit_code') </th>
                                                <th class="th_grid">@lang('models.location_code') </th>
                                                <th class="th_grid">@lang('models.product_code') </th>
                                                <th class="th_grid">@lang('models.pallet_id') </th>
                                                <th class="th_grid">@lang('models.label_id') </th>
                                                <th class="th_grid">@lang('models.qty_wms') </th>
                                                <th class="th_grid">@lang('models.uom_code') </th>
                                                <th class="th_grid">@lang('models.1acount') </th>
                                                <th class="th_grid">@lang('models.2acount') </th>
                                                <th class="th_grid">@lang('models.3acount') </th>
                                                <th class="th_grid">@lang('models.4acount') </th>
                                            </thead>
                                            <tbody>
                                                @foreach($inventory_items as $item)
                                                <!-- Hidden pois o que mostra as informações é o ajax / datatable -->
                                                <tr class="hidden">
                                                    <td>{!! $item->deposit_code !!}</td>
                                                    <td>{!! $item->location_code !!}</td>
                                                    <td>{!! $item->product_code !!}</td>
                                                    <td>{!! $item->plt_barcode !!}</td>
                                                    <td>{!! $item->label_barcode !!}</td>
                                                    <td>{!! $item->qty_wms !!}</td>
                                                    <td>{!! $item->uom_code !!}</td>
                                                    <td>{!! $item->qty1 !!}</td>
                                                    <td>{!! $item->qty2 !!}</td>
                                                    <td>{!! $item->qty3 !!}</td>
                                                    <td>{!! $item->qty4 !!}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>

<script>
    var table;
    $(function() {
        var groupColumn = 0;
       //Parâmetros para criação da datatable
       table = $("#relInv-table").DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf',
            ],
            scrollX: true,
            scrollY: "60vh",
            pageLength: 100,
            ajax: "{{url('inventoryItems/'.$document_id.'/datatable')}}",
            autoWidth: true,
            columnDefs: [
            { "visible": false, "targets": groupColumn }
            ],
            "oLanguage": {
                sLengthMenu: "@lang('models.show') _MENU_ @lang('models.entries')",
                sSearch: "<img class='icon-s' src='{{asset('/icons/buscar.png') }}'>",
                sInfo: " _START_ a _END_ - _TOTAL_ @lang('models.entries')",
                "oPaginate": {
                    sFirst: "@lang('models.first')",
                    sLast: "@lang('models.last')", 
                    sNext: "@lang('models.next')", 
                    sPrevious: "@lang('models.previous')",
                }
            },
            columns: [  { data: 'deposit_code', className: "td_center"},
                        { data: 'location_code', className: "td_center" },
                        { data: 'product_code', className: "td_center" },
                        { data: 'plt_barcode', className: "td_center" },
                        { data: 'label_barcode', className: "td_center" },
                        { data: 'qty_wms'},
                        { data: 'uom_code', className: "td_center"},
                        { data: 'qty1'},
                        { data: 'qty2'},
                        { data: 'qty3'},
                        { data: 'qty4'}],
            "drawCallback": function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
                var qty1 = 0;
                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="dataTables_group"><td style="padding: 2px 15px !important" colspan="11">Depósito: '+group+'</td></tr>'
                        );
    
                        last = group;
                    }
            } );
        }
      });   
               
    });

</script>
@endsection