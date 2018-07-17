@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.logs') 
                </div>
                <div class="panel panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Alerta de erro / sucesso -->
                            @include('flash::message')
                            <div id="msg_excluir"></div>
                            <div class="panel-body">
                                @include('logs.table')
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
        table = $("#logs-table").DataTable({
            scrollX: true,
            scrollY: "60vh",
            ajax: 'logs/datatable',
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
            columns: [ { data: 'description' },
                       { data: 'code' },
                       { data: 'operation_code' },
                       { data: 'created_at'}],
            "order": [[ 3, "desc" ]]
      });

      //Funções dos botões de editar e excluir
      $('#logs-table tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('logs/"+data.id+"/edit') !!}";
            }else{
                //Excluir Registro
                if(confirm('@lang("buttons.msg_remove")')){
                    //Token obrigatório para envio POST
                    var tk = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: 'logs/'+data.id,
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

    //Refresh do grid  (30 segundos)
    setInterval( function () {
        table.ajax.reload( null, false );
    }, 30000 );
                    
    });

</script>
@endsection