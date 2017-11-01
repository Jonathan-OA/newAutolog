@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.user_permissions') 
                </div>
                
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            @include('flash::message')
                            <div id="msg_excluir"></div>
                            <div class="row buttons_grid">
                                <a class="btn btn-success"  href="{!! route('userPermissions.create') !!}">@lang('buttons.add')</a>
                            </div>
                            <div class="panel-body">
                                @include('user_permissions.table')
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
        table = $("#userPermissions-table").DataTable({
            scrollX: true,
            scrollY: "47vh",
            ajax: 'userPermissions/datatable',
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
            columns: [ { data: 'user_type_code' },
                { data: 'operation_code' },
               
                       { data: null,
                         className: "td_grid",
                         defaultContent: "<button id='edit' aria-label='@lang('buttons.edit')' data-microtip-position='left' role='tooltip' ><img class='icon' src='<% asset('/icons/editar.png') %>'></button><button id='remove' aria-label='@lang('buttons.remove')' data-microtip-position='left' role='tooltip'><img class='icon' src='<% asset('/icons/remover.png') %>'></button>",
                         width: "90px" 
                       }],
      });

      //Funções dos botões de editar e excluir
      $('#userPermissions-table tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('userPermissions/"+data.id+"/edit') !!}";
            }else{
                //Excluir Registro
                if(confirm('@lang("buttons.msg_remove")')){
                    //Token obrigatório para envio POST
                    var tk = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: 'userPermissions/'+data.id,
                        type: 'post',
                        data: {_method: 'delete', _token :tk},
                        success: function(scs){ 
                            //Recarrega grid sem atualizar a página
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