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
                                {!! Form::open(['url' => 'inventory/'.$document->id.'/selectItemsCount/2']) !!}
                                <div class="col-md-4">
                                    <!-- Filtros -->
                                    {!! Form::label('filterDep', Lang::get('models.deposits').':') !!}
                                    {!! Form::text('filterDep', null, ['class' => 'form-control','id' => 'autocomplete1', 'table' => 'deposits', 'multiple']) !!}
                                </div>
                                <div class="col-md-3">
                                    {!! Form::label('filterDiv1', 'Diverg. maior que :') !!}
                                    {!! Form::number('filterDiv1', null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-3">
                                        {!! Form::label('filterDiv2', 'Diverg. menor que :') !!}
                                        {!! Form::number('filterDiv2', null, ['class' => 'form-control','id' => 'divMin']) !!}
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
            $(this).children('input').prop("checked", true).trigger('change');
        })

        $("#autocomplete1").change(function(){
            console.log($(this).val());
        })
        /*
        //Funções de seleção de Prox Contagem ou Finalização
        $("input[type='radio']").change(async function(){
            //Value F = Finalizar; Value P = Prox Contagem
            var value = $(this).val();

            var product = $(this).attr('prd'); //Produto
            var location = $(this).attr('loc'); //Endereço
            let code = product+location+'Det';

            if(value == 'P'){
                //Apaga as linhas de detalhes do item e endereço, se houver
                $("#tr"+code).remove();
            }else{
                //Insere uma table com os detalhes de palete, etiqueta e quantidades
                var count = 2;
                var trRef = $(this).parents('tr');

                await $.ajax({
                    url: '{!! url("/inventory/$document->id/detItemsNextCount") !!}',
                    type: 'POST',
                    data: {product, location, count, _token: $('meta[name="csrf-token"]').attr('content')},
                    success: function(data){ 
                        //Cabeçalho
                        trRef.after('<tr id="tr'+code+'" class="lineDet"><td class="wborder" colspan=2><img src="{!! asset("/icons/right-arrow.png") !!}" /></td><td colspan="5"><table id="'+code+'" class="table table-bordered" height="100%" width="100%"><thead><tr><th class="th_grid">Palete</th><th class="th_grid">Etiqueta</th><th class="th_grid">Saldo Final</th></tr></thead><tbody>');

                            //console.log($("#teste"));
                        data.forEach(function(line){
                            //console.log($(this).parents('tr'));
                            $('#'+code).append('<tr><td align="center" width="30%">'+line.plt_barcode+'</td><td align="center" width="30%">'+line.label_barcode+'</td><td align="center" width="40%"><input class="form-control" type="number" value="'+line.qty_wms+'"/></td></tr>');
                        })
                        trRef.after('</tbody></table></td></tr>');
                    }
                })
            }
        })*/


        
    });

</script>
@endsection