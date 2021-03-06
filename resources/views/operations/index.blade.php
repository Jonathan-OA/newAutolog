@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   <!-- Botão de Voltar e Título baseado no arquivo de linguagem -->
                   <a href="{{ URL::previous() }}" aria-label="@lang('buttons.back')" data-microtip-position="bottom" role="tooltip">
                        <img  class="icon_menu" src="{{asset('/icons/voltar.png') }}"/>
                    </a>  @lang('models.operations') 
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Alerta de erro / sucesso -->
                        @include('flash::message')
                        <div id="msg_excluir"></div>
                        <div class="row buttons_grid">
                            <a class="btn btn-success"  href="{!! route('operations.create') !!}">@lang('buttons.add')</a>
                            <!-- Visualizar Logs  -->
                            <a class="icon_logs" href="{!! url('logs/operations_') !!}" aria-label="@lang('buttons.logs')" data-microtip-position="left" role="tooltip">
                                <img class='icon' src='{{asset('/icons/logs.png') }}'>
                            </a>
                        </div>
                        <div class="panel-body">
                            @include('operations.table')
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
                sSearch: "<img class='icon-s' src='{{asset('/icons/buscar.png') }}'>",
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
                        { data: 'module_name' },
                        { data: 'level' },
                        { data: 'description', className: "td_grid_dt" },
                        { data: 'writes_log', className: "td_center"},
                        { data: null,
                            className: "th_grid",
                            defaultContent: "<button id='edit' aria-label='@lang('buttons.edit')' data-microtip-position='left' role='tooltip' ><img class='icon' src='{{asset('/icons/editar.png') }}'></button><button id='remove' aria-label='@lang('buttons.remove')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='{{asset('/icons/remover.png') }}'></button>",
                            width: "90px" 
                        }],
            "rowCallback": function( row, data, index ) {
                console.log(row);
                    //Se esta inativo, coloca a linha com a cor vermelha
                    if ( data.enabled == '0' ) {
                        $(row).addClass('redClass');
                    }
                    
                    //Se ativo, coloca icone de habilitado
                    if ( data.writes_log == 1 ) {
                        $('td:eq(5)', row).html( "<img class='icon' src='{{asset('/icons/checked.png') }}'>" );
                    }else{
                        $('td:eq(5)', row).html('');
                    }
            }
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
                            //Recarrega grid sem atualizar a página
                            table.ajax.reload( null, false );
                            //Mostra mensagem de sucesso ou erro
                            $('.alert').remove();
                            $('#msg_excluir').html('<div class="alert alert-' + scs[0] + '">' + scs[1] + '</div>');
                            $('.alert').html(scs[1]);
                        }
                    });
                }
            }
            
    });
                    
    });

</script>
@endsection