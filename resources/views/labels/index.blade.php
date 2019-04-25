@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   <!-- Botão de Voltar e Título baseado no arquivo de linguagem -->
                   <a href="{{ URL::previous() }}" aria-label="@lang('buttons.back')" data-microtip-position="bottom" role="tooltip">
                        <img  class="icon_menu" src="{{asset('/icons/voltar.png') }}"/>
                    </a>  @lang('models.labels') 
                </div>
                <!-- Modal de Impressão -->
                <div class="modal fade" id="printModal" tabindex="-1" role="dialog"  aria-hidden="true">
                    @include('layouts.print')
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Alerta de erro / sucesso -->
                        @include('flash::message')
                        <div id="msg_excluir"></div>
                        <div class="row buttons_grid">
                            <a class="btn btn-success"  href="{!! route('labels.create') !!}">@lang('buttons.add')</a>
                            <!-- Visualizar Logs  -->
                            <a class="icon_logs" href="{!! url('logs/labels_') !!}" aria-label="@lang('buttons.logs')" data-microtip-position="left" role="tooltip">
                                <img class='icon' src='{{asset('/icons/logs.png') }}'>
                            </a>
                            <!-- Botão de Imprimir  -->
                                 
                        </div>
                        <div class="panel-body">
                            @include('labels.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    var table;
    $(function() {
        //Parâmetros para criação da datatable
        table = $("#labels-table").DataTable({
            scrollX: true,
            scrollY: "47vh",
            ajax: 'labels/datatable',
            autoWidth: true,
            fixedColumns:   {
                leftColumns: 0,
                rightColumns: 1
            },
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
            columns: [  { data: 'barcode' },
                        { data: 'product_code' },
                        { data: 'prim_qty' },
                        { data: 'prim_uom_code' },
                        { data: 'batch' },
                        { data: 'batch_supplier' },
                        { data: 'label_status_id' },
                        { data: 'due_date', 
                          className: "th_grid",
                          render: function ( data, type, row ) {
                                //Data de validade
                                return moment(data).format("DD/MM/YYYY");
                          } 
                        },
                        { data: null,
                         className: "th_grid",
                         defaultContent: "<button id='button-print' class='bprint' data-toggle='modal' data-target='#printModal' aria-label='@lang('buttons.print')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='{{asset('/icons/printer.png') }}'></button><button id='trace' aria-label='@lang('buttons.traceability')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='{{asset('/icons/detalhes2.png') }}'></button><button id='edit' aria-label='@lang('buttons.edit')' data-microtip-position='left' role='tooltip' ><img class='icon' src='{{asset('/icons/editar.png') }}'></button><button id='remove' aria-label='@lang('buttons.remove')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='{{asset('/icons/remover.png') }}'></button>",
                         width: "90px" 
                        }],
      });
      
      //Filtros adicionais
      //Apenas etiquetas vencidas
      $('#labels-table_filter').append('<input type="checkbox" id="vencidas"> Etiquetas Vencidas');
      $('#vencidas').on('change', function () {
        table.draw();
      });

      //Extensão dos filtros no datatable
      $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var dueDate =data[7] || 0; // Data de Validade
            var date = moment().format('DD-MM-YYYY'); //Data Atual
            //console.log(date+' -- '+dueDate);
            var check = $('#vencidas').prop('checked');

            if(!check || ( check && moment(dueDate).isSameOrAfter(date))){
                return true;
            }else{
                return false;
            }

        }
      )
      var data;
      //Funções dos botões de editar e excluir
      $('#labels-table tbody').on( 'click', 'button', function () {
             data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('labels/"+data.id+"/edit') !!}";
            }else if(id == 'trace'){
                //Rastreabilidade
                window.location.href = "{!! URL::to('labels/"+data.id+"/traceability') !!}";
            }else if(id == 'button-print'){
                //Atribui o tipo de etiqueta no input hidden do layout print.blade.php
                //Para que os comandos possam ser identificados
                $('#label_type_code').val(data.label_type_code);

            }else if(id == 'remove'){
                //Excluir Registro
                if(confirm('@lang("buttons.msg_remove")')){
                    //Token obrigatório para envio POST
                    var tk = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: 'labels/'+data.id,
                        type: 'post',
                        data: {_method: 'delete', _token :tk},
                        success: function(scs){ 
                            //Recarrega grid sem atualizar a página
                            table.ajax.reload( null, false );
                            //Se retornou 0, foi excluído com sucesso
                            if(scs[0] == 0){
                                alertType = 'success';
                            }else{
                                alertType = 'danger';
                            }
                            //Mostra mensagem de sucesso ou erro
                            if(!$('.alert').length){
                                $('#msg_excluir').html('<div class="alert alert-'+alertType+'">'+scs[1]+'</div>');
                            }else{
                                $('.alert').toggleClass('alert-success alert-danger', true);
                                $('.alert').html(scs[1]);

                            }
                        }
                    });
                }
            }
            
    });
                    
    });

</script>
@endsection