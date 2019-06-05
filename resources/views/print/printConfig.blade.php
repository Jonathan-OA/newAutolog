@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12 pad-ct">
            <div class="panel panel-default" >
                <div class="panel-heading">
                   <!-- Botão de Voltar e Título baseado no arquivo de linguagem -->
                   <a href="{{ URL::previous() }}" aria-label="@lang('buttons.back')" data-microtip-position="bottom" role="tooltip">
                        <img  class="icon_menu" src="{{asset('/icons/voltar.png') }}"/>
                    </a>@lang('models.printConfig') 
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form_fields">
                                            <!-- Alerta de erro / sucesso -->
                                            <div id="msg_excluir">
                                                <div class="alert alert-info">@lang('infos.printers_list')</div>
                                            </div>
                                            <label>@lang('infos.print_select')</label>
                                            <div id="printers">
                                                <!--Carregado dinamicamente com o resultado do ajax ao carregar a pag -->
                                            </div>
                                        </div>
                                        {!! Form::button(Lang::get('buttons.save'), ['class' => 'btn btn-primary', 'id' => 'savePrint']) !!}
                                    </div>
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
        $(function() {
            var check = "";
            //Lista todas as impressoras instaladas no computador
            $.ajax({url: "http://localhost:9101/allPrinters",
                    method: "POST",
                    timeout: 4000,
                    success: function (printers) {
                        $.each(printers['printers'], function(index,value){
                            //Valida se o retorno da impressora indica se já foi setada ou não
                            if(value['status'] === true){
                                check = 'checked';
                            }else{
                                check = '';
                            }
                            $("#printers").append('<div class="col-md-6 printConfig"> '+value['name']+'<div class="onoffswitch">\
                                                        <input type="hidden" name="printers[]"  value="0" >\
                                                        <input name="printers" class="onoffswitch-checkbox" type="checkbox" id="'+value['name']+'" value="'+value['name']+'" '+check+'>\
                                                        <label class="onoffswitch-label" for="'+value['name']+'">\
                                                            <span class="onoffswitch-inner"></span>\
                                                            <span class="onoffswitch-switch"></span>\
                                                        </label>\
                                                    </div></div>');
                            
                        })
                    },
                    error: function(error){
                        $('#msg_excluir .alert').remove();
                        $('#msg_excluir').html('<div class="alert alert-info"> @lang('validation.print_server')</div>');
                    }
            })

            //Ao clicar em salvar, envia as impressoras selecionadas para o servidor de impressão
            $('#savePrint').click(function(event){
                var jsonPrinters = "''";

                //Loop nos checkbox marcados
                var printers = $('input[name=printers]:checked');
                $.each(printers, function(index,value){
                    jsonPrinters = jsonPrinters + ",'"+$(value).attr('value')+"'";
                })

                $.ajax({url: "http://localhost:9101/setPrinters",
                    method: "POST",
                    type: "JSON",
                    data: "{ 'printers' : [ "+jsonPrinters+" ]}",
                    timeout: 4000,
                    success: function (data) {
                        $('#msg_excluir .alert').remove();
                        $('#msg_excluir').html('<div class="alert alert-success">@lang('validation.printers_success')</div>');
                    },
                    error: function (error) {
                        console.log("{ 'printers' : [ "+jsonPrinters+" ]}");
                        $('#msg_excluir .alert').remove();
                        $('#msg_excluir').html('<div class="alert alert-danger">@lang('validation.printers_error')</div>');
                    }
                });

            })
        })
    </script>
@endsection