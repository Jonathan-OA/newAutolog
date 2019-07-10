@extends('layouts.app')

@section('content')
    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! route('moviments.index') !!}">@lang('models.moviments')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('models.liberation_rules')</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel pbread panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.liberation_rules') - {!! $moviment_code !!}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Alerta de erro / sucesso -->
                        @include('flash::message')
                        <div id="msg_excluir"></div>
                        <div class="row buttons_grid">
                            <a class="btn btn-success"  href="{!! URL::to('liberationRules/create/'.$moviment_code) !!}">@lang('buttons.add')</a>
                        </div>
                        <div class="panel-body">
                            @include('liberation_rules.table')
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
        table = $("#liberationRules-table").DataTable({
            scrollX: true,
            scrollY: "40vh",
            ajax: "{!! URL::to('liberationRules/datatable/'.$moviment_code) !!}",
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
            columns: [  { data: 'code', className: 'td_center'  },
                        { data: 'description' },
                        { data: 'enabled', className: 'td_center'  },
                        { data: null,
                         className: "th_grid",
                         defaultContent: "<button id='edit' aria-label='@lang('buttons.edit')' data-microtip-position='left' role='tooltip' ><img class='icon' src='{{asset('/icons/editar.png') }}'></button><button id='remove' aria-label='@lang('buttons.remove')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='{{asset('/icons/remover.png') }}'></button>",
                         width: "90px" 
                        }],
            "rowCallback": function( row, data, index ) {
                    //Se ativo, coloca icone de habilitado
                    if ( data.enabled == 1 ) {
                        $('td:eq(3)', row).html( "<img class='icon' src='{{asset('/icons/checked.png') }}'>" );
                    }else{
                        $('td:eq(3)', row).html('');
                    }
                }
      });

      //Funções dos botões de editar e excluir
      $('#liberationRules-table tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('liberationRules/"+data.id+"/edit') !!}";
            }else{
                //Excluir Registro
                if(confirm('@lang("buttons.msg_remove")')){
                    //Token obrigatório para envio POST
                    var tk = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "{!! URL::to('liberationRules/"+data.id+"') !!}",
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