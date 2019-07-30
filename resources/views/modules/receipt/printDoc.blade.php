@extends('layouts.app')
@section('content')

    <!-- BreadCrumb - Trilha  -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! route('receipt.index') !!}">@lang('models.receipt')</a></li>
        <li class="breadcrumb-item active" aria-current="page">@lang('buttons.print')</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default pbread" >
                <div class="panel-heading">
                    @lang('models.print_doc') - @lang('models.document_edit') {{$document->number}}
                </div>
                <div class="panel-body" >
                    <div class="row">
                        <div class="col-md-12">
                            
                            <div class="form_fields form_bread">
                                <!-- Alerta de erro / sucesso -->
                                <div id="msg_excluir"></div>
                                
                                {!! Form::open(['route' => 'receipt.print']) !!}
        
                                <!-- Modal de Impressão -->
                                <!-- Passa como parâmetro para a modal o nome do módulo para indicar o controller para acessar as funções -->
                                @include('layouts.print', ['module' => 'receipt'])

                                <!-- Tipo de Etiqueta a Ser gerada -->
                                <input id="label_type_code" type="hidden" name="label_type_code" value="PRDCAD">

                                <!-- ID do Documento -->
                                <input id="document_id" type="hidden" name="document_id" value="{{$document->id}}">
                                <!-- -->

                            </div>
                            <a href="#" id="buttonPrint" data-toggle='modal' data-target='#printModal' class="btn btn-primary">@lang('buttons.print')</a>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            //Funções ao preencher um campo de input
            $("input").on('keyup change',function () {
                var tr = $(this).closest('tr');
                var divInput = $(this).closest('div');
                var id = $(this).attr('id'); //Pega o ID para identificar o input

                // Ao alterar a quantidade impressa, multiplica pela quantidade para calcular o total
                if(id == 'qty_print' || id == 'prim_qty'){
                    var qty_print = parseFloat(tr.find('input#qty_print').val());
                    var prim_qty = parseFloat(tr.find('input#prim_qty').val());
                    var total = qty_print * prim_qty;
                    //Atribui valor a coluna correta
                    tr.find('td.total').html(total);
                }

                if(id == 'qty_print' || id == 'prim_qty'){
                    var qty_print = parseFloat(tr.find('input#qty_print').val());
                    var prim_qty = parseFloat(tr.find('input#prim_qty').val());
                    var total = qty_print * prim_qty;
                }

                //Se preencheu todos os campos obrigatórios da linha, retira o ícone de aviso
                if($(this).val() != ''){
                    divInput.removeClass('input_error');
                    if(tr.find('div.input_error').length == 0){
                        tr.find('a#requiredFields').hide();
                    }else{
                        tr.find('a#requiredFields').show();
                    }
                }else if(divInput.hasClass('required')){
                    //Se o campo foi limpo e é um campo obrigatório (classe required), volta a classe q informa erro
                    divInput.addClass('input_error');
                }
                
            })

            //Ao clicar no icone de atenção na linha, da o focus no próximo input que precisa preencher
            $("#requiredFields").on('click',function () {
                var tr = $(this).closest('tr');
                //input com a classe input_error
                tr.find('div.input_error input').focus();
            })

            //Ao clicar em imprimir, valida se todos os campos foram preenchidos (se existir a classe input_error)
            $("#buttonPrint").on('click',function (event) {
                $('#msg_print .alert').remove();
                if($('#print-table').find('div.input_error').length > 0){

                    //Mensagem de erro
                    $('#msg_excluir .alert').remove();
                    $('#msg_excluir').html('<div class="alert alert-danger">@lang('infos.required_fields')</div>');
                    event.stopPropagation();

                }
                
            })

        })
    </script>

@endsection