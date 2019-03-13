@extends('layouts.app')

@section('content')
<!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! route('documentTypes.index') !!}">@lang('models.document_types')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('buttons.rules')</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel pbread panel-default" style="height: 90vh">
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.document_type_rules')  - {{ $document_type_code }}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Alerta de erro / sucesso -->
                        @include('flash::message')
                        <div id="msg_excluir"></div>
                        <div class="panel-body">
                            @include('document_type_rules.table')
                        </div>
                    </div>
                </div>
                <!-- Lista todas as regras disponíveis -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-default">
                            <div class="panel-heading"> Regras Disponíveis no Módulo </div>
                            @include('document_type_rules.tableAdd')
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
        table = $("#documentTypeRules-table").DataTable({
            scrollX: true,
            scrollY: "30vh",
            ajax: "{{url('documentTypeRules/datatable/'.$document_type_code)}}",
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
                        { data: 'order', className: 'td_center' },
                        { data: 'parameters', visible: false},
                        { data: null,
                         className: "th_grid",
                         defaultContent: "<button class='remove' aria-label='@lang('buttons.remove')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='{{asset('/icons/remover.png') }}'></button>",
                         width: "90px" 
                        }
                       ],
      });

      //Funções dos botões excluir
      $('#documentTypeRules-table tbody').on( 'click', 'button', function () {
          //Pega infos da linha
            var data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            console.log(data);
            //Excluir Registro
            if(confirm('@lang("buttons.msg_remove")')){
                //Token obrigatório para envio POST
                var tk = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{url('documentTypeRules/')}}/"+data.id,
                    type: 'post',
                    data: {_method: 'delete', _token :tk},
                    success: function(scs){ 
                        //Recarrega grid sem atualizar a página
                        table.ajax.reload( null, false );
                    }
                });

                //Valida se linha existe na tabela de regras disponiveis (table documentTypeRules-add)
                if ($("#"+data.code).length){
                    //Apenas mostra a linha
                    $("#"+data.code).show();
                }else{
                    if(!data.description.length){
                        data.description = '';
                    }
                    //Insere nova linha
                    $('#documentTypeRules-add tbody').append(
                        '<tr>\
                        <td class="th_grid"> <button class="add" aria-label="@lang('buttons.add')" data-microtip-position="left" role="tooltip" ><img class="icon" src="{{asset('/icons/add.png') }}"></button> </td>\
                        <td class="td_center">'+data.code+'</td>\
                        <td>'+data.description+'</td>\
                        <td>'+data.parameters+'</td>\
                        </tr>');
                }
               
            }
        });

        //Função que adiciona as regras selecionadas na tabela de baixo
        $('#documentTypeRules-add tbody').on( 'click', 'button', function () {
            var tr = $(this).closest('tr');
            //Código da regra
            var cod = $(this).closest('tr').children()[1].innerText;
            //Descrição
            var desc = $(this).closest('tr').children()[2].innerText;

            //Token obrigatório para envio POST
            var tk = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{url('documentTypeRules/'.$document_type_code)}}",
                type: 'post',
                data: {_method: 'post', _token :tk, liberation_rule_code: cod, document_type_code: "{{$document_type_code}}"},
                success: function(scs){ 
                    //Recarrega grid sem atualizar a página e esconde a linha
                    table.ajax.reload( null, false );
                    tr.hide();
                }
            });
        })
                    
    });

</script>
@endsection