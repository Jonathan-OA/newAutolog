@extends('layouts.app')

@section('content')
<!-- BreadCrumb - Trilha  -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page">@lang('models.admin')</li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="{!! url('/admin/reportBranchs') !!}"> @lang('reports.reportBranchs') </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">@lang('buttons.detail')</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 pad-ct">
        <div class="panel pbread panel-default">
            <div class="panel-heading">
                <!-- Texto baseado no arquivo de linguagem -->
                @lang('reports.reportBranchsDet'): {{$branch->name}}
            </div>
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
                                            <th class="th_grid">@lang('models.branch') </th>
                                            <th class="th_grid">@lang('models.date') </th>
                                            <th class="th_grid">@lang('models.inventory_number') </th>
                                            <th class="th_grid">@lang('models.customer_code') </th>
                                            <th class="th_grid">@lang('models.billing_type') </th>
                                            <th class="th_grid">@lang('models.inventory_value') </th>
                                            <th class="th_grid">@lang('models.qty_parts') </th>
                                            <th class="th_grid">@lang('models.average_item') </th>
                                            <th class="th_grid">@lang('models.total') </th>
                                            <th class="th_grid">@lang('models.royalties') </th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th> ### </th>
                                                <th> ### </th>
                                                <th> ### </th>
                                                <th> ### </th>
                                                <th></th>
                                                <th></th>
                                                <th> ### </th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
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
    var urlSummarized = "{{url('admin/reportBranchsDet/datatable/'.$branch->id)}}";
    var summarize = 1;
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
            ajax: urlSummarized,
            autoWidth: true,
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
            columns: [{ data: 'branch', className: "td_center" },
                      { data: 'start_date', 
                          className: "td_center",
                          render: function ( data, type, row ) {
                                //Data de validade
                                return moment(data).format("DD/MM/YYYY");
                          } 
                      },
                      { data: 'number', className: "td_center" },
                      { data: 'trading_name', className: "td_center" },
                      { data: 'billing_type', className: "td_center" },
                      { data: 'inventory_value', className: "td_center",
                        render: $.fn.dataTable.render.number( '.',',',2, 'R$ '),  },
                      { data: 'items', className: "td_center",
                        render: $.fn.dataTable.render.number( '.','',0 ),  },
                      { data: 'average', className: "td_center",
                        render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' ),  },
                      { data: 'total', className: "td_center", 
                        render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' ), 
                      },
                      { data: 'royalties', className: "td_center",
                        render: $.fn.dataTable.render.number( '.', ',', 2, 'R$ ' ), }
                      ],
            "initComplete": function() {
            },
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                var qty1 = 0;
                api.column(groupColumn, {
                    page: 'current'
                }).data().each(function(group, i) {

                    if (last !== group && summarize == 0) {
                        $(rows).eq(i).before(
                            '<tr class="dataTables_group"><td style="padding: 2px 15px !important" colspan="11">Endereço: ' + group + '</td></tr>'
                        );

                        last = group;
                    }
                });
            },
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // Total
                pageTotal = api
                    .column( 8, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                var valorFechado = api
                    .column( 5, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                var totalPecas = api
                    .column( 6, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                
                 // Total Royalties 
                 royalTotal = api
                    .column( 9, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Update footer
                $( api.column( 5 ).footer() ).html(
                    'R$ '+ new Intl.NumberFormat('pt-BR').format(valorFechado.toFixed(2)) +' '
                );
                $( api.column( 6 ).footer() ).html(
                    totalPecas
                );
                $( api.column( 8 ).footer() ).html(
                    'R$ '+ new Intl.NumberFormat('pt-BR').format(pageTotal) +' '
                );

                $( api.column( 9 ).footer() ).html(
                    'R$ '+ new Intl.NumberFormat('pt-BR').format(royalTotal.toFixed(2)) +' '
                );

            }
        });
        $('#relInv-table_filter').append('<span style="margin-left: 40px"> {{ Form::label("period_min", "Período: ") }}' +
                    '{{ Form::date("period_min", "",["id" => "period_min"]) }} Até ' +
                    '{{ Form::date("period_max", "",["id" => "period_max"] ) }} </span>');

        //Filtro por data
        $("#period_min,#period_max").change(function(){
            var to = $("#period_max").val();
            var from = $("#period_min").val();

            console.log(to);
            console.log(from);
            if(to != "" && from != ""){
                //Recarrega o datatable com os filtros
                table.ajax.url(urlSummarized+"/"+from+"/"+to);
                table.ajax.reload();
            }
        });
    });
</script>
@endsection