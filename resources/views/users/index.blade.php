@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.users') 
                </div>
                
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            @include('flash::message')
                            <div id="msg_excluir"></div>
                            <div class="row buttons_grid">
                                <a class="btn btn-success"  href="{!! route('users.create') !!}">@lang('buttons.add')</a>
                            </div>
                            <div class="panel-body">
                                @include('users.table')
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
        table = $("#users-table").DataTable({
            scrollX: true,
            scrollY: "47vh",
            ajax: 'users/datatable',
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
            columns: [ { data: 'code', className: 'td_center' },
                       { data: 'name' },
                       { data: 'email' },
                       { data: 'user_type_code', className: 'td_center' },
                       { data: null,
                         className: "td_grid",
                         defaultContent: "<button id='edit' aria-label='@lang('buttons.edit')' data-microtip-position='left' role='tooltip' ><img class='icon' src='{{asset('/icons/editar.png') }}'></button><button id='remove' aria-label='@lang('buttons.remove')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='{{asset('/icons/remover.png') }}'></button>",
                         width: "90px" 
                       }],
      });

      //Funções dos botões de editar e excluir
      $('#users-table tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('users/"+data.id+"/edit') !!}";
            }else{
                //Excluir Registro
                if(confirm('@lang("buttons.msg_remove")')){
                    //Token obrigatório para envio POST
                    var tk = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: 'users/'+data.id,
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