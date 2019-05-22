<!-- Layout da modal para realizar impressões -->

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
                <div class="panel-default" >
                    <div class="panel-heading">
                        @lang('models.print') 
                        <a class="btn btn-printConfig" href="#" id="button-printConfig" title="Habilitar Impressoras">
                            <img class="icon" src="{{ asset('/icons/config.png') }}" alt="Habilitar Impressoras" >
                        </a>        
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
        //Chama ao clicar no botão para abrir a modal (primeiro botão de imprimir)
        $('#printModal').on('shown.bs.modal', function(){

            label_type = $('#label_type_code').val();
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
                //Erro na Busca do Servidos
                var msg = "@lang('validation.label_types')";
                $('#msg_print .alert').remove();
                $('#msg_print').html('<div class="alert alert-info">'+msg+' (Ajax)</div>');
            });

            //Lista impressoras disponíveis
            //PrintServer TWX
            $.ajax({
                url: "http://localhost:9101/printers",
                method: "POST",
                timeout: 4000 //Timeout de 4 Segundos
            }).done(function(options) {
                //Pega variável salva no browser com a ultima fila utilizada
                var lastPrinter = localStorage.getItem("AutologWMS_LastPrinter");

                //Loop no resultado para montar o select
                $.each(options['printers'], function(index,value){
                    var key = Object.keys(value)[0];
                    if(value[key] == lastPrinter){
                        $("#printers").append('<option value="'+value[key]+'" selected>'+key+'</option>');
                    }else{
                        $("#printers").append('<option value="'+value[key]+'">'+key+'</option>');
                    }
                })
            }).fail(function(jqXHR, textStatus) {
                //Erro de nenhuma impressora encontrada (Print Server pode estar desativado)
                var msg = "@lang('validation.print_server')";
                $('#msg_print .alert').remove();
                $('#msg_print').html('<div class="alert alert-info">'+msg+'</div>');
                //Sugestão de link com FAQ para configurar impressão
                $('#msg_excluir .alert').remove();
                $('#msg_excluir').html('<div class="alert alert-info">@lang('infos.print_server') <a href="#">Clique Aqui</a></div>');
            });
        })

        //Ao clicar no botão Imprimir (depois de selecionar fila e tipo de impressora)
        $('#formPrint').click(function(event){
            event.preventDefault();

            //Pega quantidade
            qty_print = $("#qty_print").val();

            //Pega impressora selecionada
            printer = $("#printers").val();

            //Pega tipo de impressora selecionada
            printer_type = $("#printer_type_code").val();

            if(printer_type != '' && printer != '' && qty_print > 0){
                //Pega os dados do formulário preenchido (etiquetas, lotes, produtos, etc.)
                //e envia via ajax para impressão
                var formData = $('form').serialize();

                //Primeiro ajax envia o formulário com os dados da etiqueta / documento para realizar a substituição 
                //das variaveis nos layouts. Função print() no controler ProductionController
                $.ajax({
                    url: "{!! URL::to('production/print') !!}",
                    method: "POST",
                    data: formData,
                    success: function (fileCommands) {
                        //Segundo ajax envia o conteúdo para impressão
                        $.ajax({
                            url: "http://localhost:9101/printer/"+printer,
                            method: "POST",
                            data: fileCommands,
                            success: function (data) {
                                //Mostra mensagem de sucesso
                                $('.alert').remove();
                                $('#msg_excluir').html('<div class="alert alert-success">@lang('infos.print_success',["printer" => "'+printer+'", "qty" => "'+qty_print+'"])</div>');
                                
                                //Salva última fila utilizada para otimizar tempos futuros
                                localStorage.setItem("AutologWMS_LastPrinter", printer);

                                //Fecha Modal
                                $('#printModal').modal('toggle');
                            },
                            error: function(){
                                //Mostra mensagem de erro
                                $('#msg_print .alert').remove();
                                $('#msg_print').html('<div class="alert alert-danger">@lang('infos.print_error',["printer" => "'+printer+'"])<</div>');
                            }
                        });
                    }
                });
            }
            

        })

        //Evento ao fechar modal - Limpa selects populados via ajax
        $('#printModal').on('hidden.bs.modal', function () {
            $("#printer_types").html("");
            $("#printers").html("");
        })

        $('#button-printConfig').click(function(){
            $.ajax({url: "http://localhost:9101/allPrinters",
                    method: "POST",
                    success: function (data) {
                        console.log(data);
                    }
            })
        })
        
    })

</script>
@endsection