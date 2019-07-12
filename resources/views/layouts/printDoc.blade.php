<!-- Layout da modal para realizar impressões -->

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
                <div class="panel-default" >
                    <div class="panel-heading">
                        <!-- Título baseado no arquivo de linguagem -->
                        @lang('models.print_doc')    
                    </div>
                </div>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                     <!-- Alerta de erro / sucesso -->
                     <div id="msg_print"></div>
                    <div class="form-group">
                        <!-- Código da empresa -->
                        <input id='company_id' name='company_id' type='hidden' value='{!! Auth::user()->company_id !!}'>

                        <!-- IP Local -->
                        <input id='ip_local' name='ip_local' type='hidden' value='{{ $_SERVER['REMOTE_ADDR'] }}'>

                        <!-- Fila -->
                        {!! Form::label('printer', Lang::get('models.printer').':') !!}
                        {!! Form::select('printer',  array() , NULL,  ['id' => 'printers', 'class' => 'form-control', 'readonly']) !!}
                        
                        <!-- Tipo de Impressora -->
                        {!! Form::label('printer_type_code', Lang::get('models.printer_type_code').':') !!}
                        {!! Form::select('printer_type_code',  array(), NULL , ['id' => 'printer_types','class' => 'form-control', 'readonly']) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('buttons.cancel')</button>
                    {!! Form::button(Lang::get('buttons.print'), ['class' => 'btn btn-primary', 'id' => 'formPrint']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts_print')
<script>
    $(function() {


        var label_type;
        var document_id;

        var ip_server = "http://localhost:9101";
        var serverPrint = "http://{{$print_server}}:9101";

        //Chama ao clicar no botão para abrir a modal (primeiro botão de imprimir)
        $('#printModal').on('shown.bs.modal', function(event){

            //Valida se o IP do parametro print_server ($print_server) esta acessível, para assumir como o padrão
            //Timeout de 2 segundos
            //Global: False para não mostrar icone de loading
            $.ajax({
                url: "http://{{$print_server}}:9101/printers",
                global: false,
                timeout: 2000,
            }).always(function(jqXHR, textStatus) {
                if (textStatus == 'success') {
                    ip_server = "http://{{$print_server}}:9101";
                }
            });
            //

            try{
                //Etiqueta e document_id enviados por parâmetro para a modal 
                //(origem: buttonsDoc - Valores: data-label_type e data-document_id)
                label_type = event.relatedTarget.dataset.label_type;
                document_id = event.relatedTarget.dataset.document_id;
            }catch(err){
                console.log(err);
            }
            
            var ip = $('#ip_local').val();

            //Carrega tipos de impressoras para o tipo de etiqueta
            //PrintServer TWX
            $.ajax({
                url: "{!! URL::to('labelLayouts/"+label_type+"/printers') !!}",
                method: "GET"
            }).done(function(options) {
                //Loop no resultado para montar o select
                $.each(options, function(index,value){
                    $("#printer_types").append('<option value="'+index+'">'+value+'</option>');
                })
                if(options.length == 0){
                    //Não foram encontradas impressoras cadastradas para este tipo
                    var msg = "@lang('validation.label_types')";
                    $('#msg_print .alert').remove();
                    $('#msg_print').html('<div class="alert alert-info">'+msg+'</div>');
                }
            }).fail(function() {
                //Erro na Busca do Servidor
                var msg = "@lang('validation.label_types')";
                $('#msg_print .alert').remove();
                $('#msg_print').html('<div class="alert alert-info">'+msg+' (Ajax)</div>');
            });

            //Lista impressoras disponíveis
            //PrintServer TWX
            $.ajax({
                url: ip_server+"/printers",
                method: "POST",
                timeout: 4000 //Timeout de 4 Segundos
            }).done(function(options) {

                //Valida se existe mais impressoras configuradas alem da TST (Primeira Vez após instalar o PrintServer)
                if(options.printers.length == 1 && options.printers[0]['TST'] == 'TST'){
                    //Abre a página de configuração em outra aba
                    window.open('{!! URL::to('printConfig') !!}', '_blank');
                }
                
                //Pega variável salva no browser com a ultima fila utilizada
                var lastPrinter = localStorage.getItem("AUTOLOGWMS_LastPrinter");
                
                //Loop no resultado para montar o select
                $.each(options['printers'], function(index,value){
                    var key = Object.keys(value)[0];
                    if(value[key] == lastPrinter){
                        $("#printers").append('<option value="'+value[key]+'" selected>'+key+'</option>');
                    }else{
                        $("#printers").append('<option value="'+value[key]+'">'+key+'</option>');
                    }
                })

                //Sugestão de link para configurar impressoras disponíveis
                $('#msg_print .alert').remove();
                $('#msg_print').html('<div class="alert alert-info">@lang('infos.printers_config') <a href="{!! URL::to('printConfig') !!}" target="_blank" >Clique Aqui</a></div>');
                
            }).fail(function(jqXHR, textStatus) {
                //Erro de nenhuma impressora encontrada (Print Server pode estar desativado)
                var msg = "@lang('validation.print_server')";
                $('#msg_print .alert').remove();
                $('#msg_print').html('<div class="alert alert-info">'+msg+'</div>');
                //Sugestão de link com FAQ para configurar impressão
                $('#msg_excluir .alert').remove();
                $('#msg_excluir').html('<div class="alert alert-info">@lang('infos.print_server', ['ip' => $print_server]) <a href="#">Ajuda</a></div>');
            });
        })
        
        //BOTÃO IMPRIMIR
        //Ao clicar no botão Imprimir (depois de selecionar fila e tipo de impressora)
        $('#formPrint').click(function(event){
            event.preventDefault();

            //Token para acessar sem erros as rotas posts
            let tk = $('meta[name="csrf-token"]').attr('content');

            //Pega impressora selecionada
            printer = $("#printers").val();

            //Pega tipo de impressora selecionada
            printer_type = $("#printer_types").val();

            if(printer_type != '' && printer != ''){

                //Primeiro ajax envia o os dados do documento para realizar a substituição 
                //das variaveis no layout. Função printDoc() no controler $moduleController.
                //$module =  recebido como parâmetro na modal que indica o controller que devemos acessar
                //as funções de busca e substituição
                
                $.ajax({
                    url: "{!! URL::to($module.'/printDoc') !!}",
                    method: "POST",
                    data: {label_type, document_id, printer, printer_type, _token: tk},
                    success: function (fileCommands) {
                        //Segundo ajax envia o conteúdo para impressão
                        $.ajax({
                            url: ip_server+"/printer/"+printer,
                            method: "POST",
                            data: fileCommands,
                            success: function (data) {
                                //Mostra mensagem de sucesso
                                $('.alert').remove();
                                $('#msg_excluir').html('<div class="alert alert-success">@lang('infos.print_success',["printer" => "'+printer+'", "qty" => "1"])</div>');
                                
                                //Salva última fila utilizada para otimizar tempos futuros
                                localStorage.setItem("AUTOLOGWMS_LastPrinter", printer);

                                //Fecha Modal
                                $('#printModal').modal('toggle');
                            },
                            error: function(){
                                console.log(fileCommands);
                                //Mostra mensagem de erro (Fila não disponível para impressão)
                                $('#msg_print .alert').remove();
                                $('#msg_print').html('<div class="alert alert-danger">@lang('infos.print_error',["printer" => "'+printer+'"])</div>');
                            }
                        });
                    },
                    error: function(error){
                        //Mostra mensagem de erro (Erro ao gerar impressão. Contate o SUPORTE para obter ajuda)
                        $('#msg_print .alert').remove();
                        $('#msg_print').html('<div class="alert alert-danger">@lang('infos.print_error_def')</div>');

                    }
                });
            }
            

        })

        //Evento ao fechar modal - Limpa selects populados via ajax
        $('#printModal').on('hidden.bs.modal', function () {
            $("#printer_types").html("");
            $("#printers").html("");
        })

        
    })

</script>
@endsection