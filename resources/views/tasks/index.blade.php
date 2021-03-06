@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.tasks') 
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Alerta de erro / sucesso -->
                        @include('flash::message')
                        <div id="msg_excluir"></div>
                        <div class="row buttons_grid">
                            <a class="btn btn-success"  href="{!! route('tasks.create') !!}">@lang('buttons.add')</a>
                        </div>
                        <div class="panel-body">
                            @include('tasks.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="//cdn.datatables.net/plug-ins/1.10.19/dataRender/datetime.js"></script>

<script>
    var table;
    $(function() {
        
        //Parâmetros para criação da datatable
        table = $("#tasks-table").DataTable({
            scrollX: true,
            scrollY: "47vh",
            ajax: 'tasks/datatable',
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
            columns: [  { data: 'id' },
                        { data: 'code', 
                          render: function ( data, type, row ) {
                            //Código + descrição
                            return data +' - '+ row.description ;
                          } 
                        },
                        { data: 'orig_location_code', className: 'td_center' },
                        { data: 'dest_location_code', className: 'td_center' },
                        { data: 'start_date', 
                          className: 'td_center',
                          render: function ( data, type, row ) {
                            //Data inicio
                            return moment(data).format("DD/MM/YYYY HH:mm");
                          }
                        },
                        { data: 'end_date', 
                          className: 'td_center', 
                          render: function ( data, type, row ) {
                            //Data fim
                            return moment(data).format("DD/MM/YYYY HH:mm");
                          }
                        }, 
                        { data: 'status_desc', className: 'td_center' },
                        { data: null,
                         className: "th_grid",
                         defaultContent: "<button id='detail' aria-label='@lang('buttons.detail')' data-microtip-position='left' role='tooltip' style='margin-right: 3px' ><img class='icon' src='{{asset('/icons/detalhes2.png') }}'><button id='edit' aria-label='@lang('buttons.edit')' data-microtip-position='left' role='tooltip' ><img class='icon' src='{{asset('/icons/editar.png') }}'></button><button id='remove' aria-label='@lang('buttons.remove')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='{{asset('/icons/remover.png') }}'></button>",
                         width: "90px" 
                        }],
      });



      //Funções dos botões de editar e excluir
      $('#tasks-table tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('tasks/"+data.id+"/edit') !!}";
            }else if(id == 'detail'){
                //Embalagens
                window.location.href = "{!! URL::to('activities/ix/"+data.id+"') !!}";
            }else{
                //Excluir Registro
                if(confirm('@lang("buttons.msg_remove")')){
                    //Token obrigatório para envio POST
                    var tk = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: 'tasks/'+data.id,
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