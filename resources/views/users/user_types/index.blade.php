@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading ptabs">
                    <!-- Abas -->
                    <ul class="nav nav-tabs">
                         <!-- Textos baseados no arquivo de linguagem -->
                         <li ><a href="{!! route('users.index') !!}">@lang('models.users') </a></li>
                         <li class="active-l"><a href="#">@lang('models.user_types')</a></li> 
                         <li ><a href="{!! url('users/online') !!}">@lang('models.users_online')</a></li>  
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @include('flash::message')
                        <div id="msg_excluir"></div>
                        <div class="row buttons_grid">
                            <a class="btn btn-success"  href="{!! route('userTypes.create') !!}">@lang('buttons.add')</a>
                            <!-- Visualizar Logs  -->
                            <a class="icon_logs" href="{!! url('logs/user_types_') !!}" aria-label="@lang('buttons.logs')" data-microtip-position="left" role="tooltip">
                                <img class='icon' src='{{asset('/icons/logs.png') }}'>
                            </a>
                        </div>
                        <div class="panel-body">
                            @include('users.user_types.table')
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
        table = $("#userTypes-table").DataTable({
            scrollX: true,
            scrollY: "47vh",
            ajax: 'userTypes/datatable',
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
            columns: [ { data: 'code' },
                       { data: 'description' },
                       { data: null,
                         className: "td_grid",
                         defaultContent: "<button id='permissions' aria-label='@lang('buttons.permissions')' data-microtip-position='left' role='tooltip' ><img class='icon' src='{{asset('/icons/permissoes2.png') }}'></button><button id='edit' aria-label='@lang('buttons.edit')'data-microtip-position='left' role='tooltip' ><img class='icon' src='{{asset('/icons/editar.png') }}'></button><button id='remove' aria-label='@lang('buttons.remove')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='{{asset('/icons/remover.png') }}'></button>",
                         width: "90px" 
                       }],
            "rowCallback": function( row, data, index ) {
                    if ( data.status == 0 ) {
                    $(row).addClass('redClass');
                    }
            }
      });

      //Funções dos botões de editar e excluir
      $('#userTypes-table tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr')).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('userTypes/"+data.id+"/edit') !!}";
            }else if(id == 'permissions'){
                //Permissões
                window.location.href = "{!! URL::to('userPermissions/"+data.code+"') !!}";
            }else{
                //Excluir Registro
                if(confirm('@lang("buttons.msg_remove")')){
                    //Token obrigatório para envio POST
                    var tk = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: 'userTypes/'+data.id,
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