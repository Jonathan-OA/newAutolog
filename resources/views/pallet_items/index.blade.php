@extends('layouts.app')

@section('content')
    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{!! route('pallets.index') !!}">@lang('models.pallets')</a></li>
          <li class="breadcrumb-item active" aria-current="page">@lang('buttons.detail')</li>
        </ol>
      </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel pbread panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.pallet_items')  - {!! $palletBarcode !!}
                </div>
                <div class="panel pbread panel-default">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Alerta de erro / sucesso -->
                            @include('flash::message')
                            <div id="msg_excluir"></div>
                            <div class="row buttons_grid">
                                <a class="btn btn-success"  href="{!! action('PalletItemController@create',$palletId) !!}">@lang('buttons.add')</a>
                            </div>
                            <div class="panel-body">
                                @include('pallet_items.table')
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
        table = $("#palletItems-table").DataTable({
            scrollX: true,
            scrollY: "40vh",
            ajax: "{!! URL::to('palletItems/datatable/'.$palletId) !!}",
            autoWidth: true,
            fixedColumns:   {
                leftColumns: 0,
                rightColumns: 1
            },
            "oLanguage": {
                sLengthMenu: "@lang('models.show') _MENU_ @lang('models.entries')",
                sSearch: "<img class='icon-s' src='<% asset('/icons/buscar.png') %>'>",
                sInfo: " _START_ a _END_ - _TOTAL_ @lang('models.entries')",
                "oPaginate": {
                    sFirst: "@lang('models.first')",
                    sLast: "@lang('models.last')", 
                    sNext: "@lang('models.next')", 
                    sPrevious: "@lang('models.previous')",
                }
            },
            columns: [  { data: 'pallet_id' },
                        { data: 'item_code' },
                        { data: 'qty' },
                        { data: 'uom_code' },
                        { data: 'prim_qty' },
                        { data: 'prim_uom_code' },
                        { data: 'label_id' },
                        { data: 'activity_id' },
                        { data: 'status' },
                        { data: 'turn' },
                        { data: null,
                    className: "th_grid",
                    defaultContent: "<button id='edit' aria-label='@lang('buttons.edit')' data-microtip-position='left' role='tooltip' ><img class='icon' src='<% asset('/icons/editar.png') %>'></button><button id='remove' aria-label='@lang('buttons.remove')' data-microtip-position='bottom' role='tooltip'><img class='icon' src='<% asset('/icons/remover.png') %>'></button>",
                    width: "90px" 
                }],
      });

      //Funções dos botões de editar e excluir
      $('#palletItems-table tbody').on( 'click', 'button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            var id = $(this).attr('id');
            if(id == 'edit'){
                //Editar Registro
                window.location.href = "{!! URL::to('palletItems/"+data.id+"/edit') !!}";
            }else{
                //Excluir Registro
                if(confirm('@lang("buttons.msg_remove")')){
                    //Token obrigatório para envio POST
                    var tk = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "{!! URL::to('palletItems/"+data.id+"') !!}",
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