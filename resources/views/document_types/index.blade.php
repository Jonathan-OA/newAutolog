@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading ptabs">
                    <!-- Abas -->
                    <ul class="nav nav-tabs">
                         <!-- Textos baseados no arquivo de linguagem -->
                         <li class="active-l"><a href="#">@lang('models.document_types') </a></li>
                         <li><a href="{!! route('moviments.index') !!}">@lang('models.moviments')</a></li>
                         <li><a href="{!! route('documentStatus.index') !!}">@lang('models.document_status')</a></li>
                     </ul>
                 </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Alerta de erro / sucesso -->
                        @include('flash::message')
                        <div id="msg_excluir"></div>
                        <div class="row buttons_grid">
                            <a class="btn btn-success"  href="{!! route('documentTypes.create') !!}">@lang('buttons.add')</a>
                            <!-- Visualizar Logs  -->
                            <a class="icon_logs" href="{!! url('logs/document_types_') !!}" aria-label="@lang('buttons.logs')" data-microtip-position="left" role="tooltip">
                                <img class='icon' src='{{asset('/icons/logs.png') }}'>
                            </a>
                        </div>
                        <div class="panel-body">
                            @include('document_types.table')
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
        table = $("#documentTypes-table").DataTable({
            scrollX: true,
            scrollY: "47vh",
            ajax: 'documentTypes/datatable',
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
            columns: [  { data: 'code', className: 'td_center' },
                        { data: 'description' },
                        { data: 'moviment_code', className: 'td_center' },
                        { data: 'operation_code', className: 'td_center' },
                        { data: 'lib_location', className: 'td_center' },
                        { data: 'print_labels', className: 'td_center' },
                        { data: 'print_labels_doc', className: 'td_center' },
                        { data: null,
                         className: "th_grid",
                         defaultContent: "<button id='edit' aria-label='@lang('buttons.edit')' data-microtip-position='left' role='tooltip' ><img class='icon' src='{{asset('/icons/editar.png') }}'></button><button id='remove' aria-label='@lang('buttons.remove')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='{{asset('/icons/remover.png') }}'></button><button id='rules' aria-label='@lang('buttons.rules')' data-microtip-position='left' role='tooltip'><img class='icon' src='{{asset('/icons/rules.png') }}'></button>"
                        }],
            "rowCallback": function( row, data, index ) {
                    //Se ativo, coloca icone de habilitado
                    if ( data.lib_location == 1 ) {
                        $('td:eq(4)', row).html( "<img class='icon' src='{{asset('/icons/checked.png') }}'>" )
                    }else{
                        $('td:eq(4)', row).html('');
                    }
                    //Se ativo, coloca icone de habilitado
                    if ( data.print_labels == 1 ) {
                        $('td:eq(5)', row).html( "<img class='icon' src='{{asset('/icons/checked.png') }}'>" )
                    }else{
                        $('td:eq(5)', row).html('');
                    }
                    //Se ativo, coloca icone de habilitado
                    if ( data.print_labels_doc == 1 ) {
                        $('td:eq(6)', row).html( "<img class='icon' src='{{asset('/icons/checked.png') }}'>" )
                    }else{
                        $('td:eq(6)', row).html('');
                    }
                }
      });

      //Funções dos botões de editar e excluir
      $('#documentTypes-table tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('documentTypes/"+data.id+"/edit') !!}";
            }else if(id == 'rules'){
                //Regras de Liberação
                window.location.href = "{!! URL::to('documentTypeRules/"+data.code+"') !!}";
            }else{
                //Excluir Registro
                if(confirm('@lang("buttons.msg_remove")')){
                    //Token obrigatório para envio POST
                    var tk = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: 'documentTypes/'+data.id,
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