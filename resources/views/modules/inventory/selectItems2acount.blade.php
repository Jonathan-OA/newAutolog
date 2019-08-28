@extends('layouts.app')
@section('content')
    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{!! route('inventory.index') !!}">@lang('models.inventory')</a></li>
          <li class="breadcrumb-item active" aria-current="page">@lang('buttons.2acont')</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel pbread panel-default" >
                <div class="panel-heading">
                   <!-- Texto baseado no arquivo de linguagem -->
                   @lang('models.items_select') - {{$document->document_type_code}} {{$document->number}}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @include('flash::message')
                        <div id="msg_excluir"></div>
                        <div class="panel-body">
                            <div class="row">
                                {!! Form::open(['url' => 'inventory/'.$document->id.'/selectItems']) !!}
                                <div class="col-md-10">
                                    <!-- Deposits Field -->
                                    {!! Form::label('deposits', Lang::get('models.deposits').':') !!}
                                    {!! Form::text('deposits', null, ['class' => 'form-control','id' => 'autocomplete1', 'table' => 'deposits', 'multiple']) !!}
                                </div>
                                <div class="col-md-2" style="padding-top:25px">
                                    {!! Form::submit(Lang::get('buttons.filter'), ['class' => 'btn btn-primary']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['url' => 'inventory/'.$document->id.'/updateItemsNextCount']) !!}
                                        <div class="form-group" style="overflow-y: auto">
                                                @include('modules.inventory.fieldsSelectItemsCount')
                                        </div>
                                    {!! Form::close() !!}
                                </div>
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
        //Função para selecionar todos os endereços do depósito
        $("input[type='checkbox']").change(function(){
            //Primeira letra do ID significa finalização ou prox contagem
            var id = $(this).attr("id");
            //Pega nome do depósito clicado
            var deposit = $(this).attr("value");
            //Pega todos os elementos com o input correto (prox ou finalização)
            if(id.substr(0,1) == 'F'){
                //Tira o check do outro checkbox do deposito
                $("input[type='checkbox'][id^='P_"+deposit+"']").prop('checked', false);
            }else{
                $("input[type='checkbox'][id^='F_"+deposit+"']").prop('checked', false);
            }

            var locations = $("input[id^='"+id.substr(0,1)+deposit+"']");
            
            //Seleciona todos da coluna
            if($(this).prop('checked')){
                locations.prop('checked', true).trigger('click');
            }else{
                locations.prop('checked', false).trigger('change');
            }

        })

        //Função para selecionar radio button ao clicar na celula
        $(".radioClick").click(function(){
            $(this).children('input').prop("checked", true);
        })

        //Ao clicar em finalizar, busca os detalhes de cada linha produto/location 
        $("input[type='radio'][value='F']").click(async function(){
            var product = $(this).attr('prd'); //Produto
            var location = $(this).attr('loc'); //Endereço
            var count = 2;

            var trRef = $(this).parents('tr');

            await $.ajax({
                url: '{!! url("/inventory/$document->id/detItemsNextCount") !!}',
                type: 'POST',
                data: {product, location, count, _token: $('meta[name="csrf-token"]').attr('content')},
                success: function(data){ 
                    data.forEach(function(line){
                        //console.log($(this).parents('tr'));
                        trRef.after('<tr class="lineDet"><td class="wborder" colspan=2><img src="{!! asset("/icons/right-arrow.png") !!}" /></td><td>Palete: '
                                            +line.plt_barcode
                                            +'</td><td>Etiqueta: '+line.label_barcode
                                            +'</td><td>UOM: '+line.uom_code
                                            +'</td><td>Final: <input type="number" value="'+line.qty_wms
                                            +'"/> '+line.uom_code+'</td></tr>');
                    })
                }
            })

            
        })


        
    });

</script>
@endsection