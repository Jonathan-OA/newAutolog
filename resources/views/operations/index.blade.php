@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.operations') 
                </div>
                
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            @include('flash::message')
                            <div id="msg_excluir"></div>
                            <div class="row buttons_grid">
                                <a class="btn btn-success"  href="{!! route('operations.create') !!}">@lang('buttons.add')</a>
                            </div>
                            <div class="panel-body">
                                @include('operations.table')
                            </div>
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
       table = $("#operations-table").DataTable({
            scrollX: true,
            scrollY: "47vh",
            ajax: 'operations/datatable',
            autoWidth: true,
            fixedColumns:   {
                leftColumns: 0,
                rightColumns: 1
            },
            "oLanguage": {
                sLengthMenu: "@lang('models.show') _MENU_ @lang('models.entries')",
                sSearch: "@lang('models.search'): ",
                sInfo: " _START_ a _END_ - _TOTAL_ @lang('models.entries')",
                "oPaginate": {
                    sFirst: "@lang('models.first')",
                    sLast: "@lang('models.last')", 
                    sNext: "@lang('models.next')", 
                    sPrevious: "@lang('models.previous')",
                }
            },
            columns: [  { data: 'code', className: 'dt-body-right'},
                        { data: 'type' },
                        { data: 'module' },
                        { data: 'level' },
                        { data: 'action' , className: "td_grid_dt" },
                        { data: 'description', className: "td_grid_dt" },
                        { data: 'local' },
                        { data: 'writes_log' },
                        { data: 'enabled' },
                        { data: null,
                            className: "th_grid",
                            defaultContent: "<button id='edit' aria-label='@lang('buttons.edit')' data-microtip-position='left' role='tooltip' ><img class='icon' src='<% asset('/icons/editar.png') %>'></button><button id='remove' aria-label='@lang('buttons.remove')' data-microtip-position='left' role='tooltip'><img class='icon' src='<% asset('/icons/remover.png') %>'></button>",
                            width: "90px" 
                        }],
      });   
      
      //Funções dos botões de editar e excluir
      $('#operations-table tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('operations/"+data.id+"/edit') !!}";
            }else{
                //Excluir Registro
                if(confirm('@lang("buttons.msg_remove")')){
                    //Token obrigatório para envio POST
                    var tk = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: 'operations/'+data.id,
                        type: 'post',
                        data: {_method: 'delete', _token :tk},
                        success: function(scs){
                            //Atualiza o grid sem recarregar a pagina
                            table.ajax.reload( null, false );
                            //Mostra mensagem de sucesso
                            if(!$('.alert-success').length){
                                $('#msg_excluir').html('<div class="alert alert-success">@lang("validation.delete_success")</div>');
                            }else{
                                $('.alert-success').html('@lang("validation.delete_success")');
                            }
                        }
                    });
                }
            }
            
    });
                    
    });

</script>
@endsection