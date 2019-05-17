<!-- Layout da modal para realizar impressões -->
<!-- Caso a variável $print seja verdadeira, envia o conteúdo de impressao ($filePrint) para a impressora -->
@if(!empty(Session::get('print')))
    <script onload="printLabel('{{Session::get('filePrint')}}')"> </script>
@endif

<div class="modal-dialog" role="document">

    <div class="modal-content">
        <div class="modal-header">
                <div class="panel-default" >
                <div class="panel-heading">
                        @lang('models.print')
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
        //Chama ao clicar no botão para abrir a modal
        $('#printModal').on('shown.bs.modal', function(){

            label_type = $('#label_type_code').val();
            var ip = $('#ip_local').val();
            //Carrega impressoras para o tipo de etiqueta
            //PrintServer TWX
            $.ajax({
                url: "{!! URL::to('labelLayouts/"+label_type+"/printers') !!}",
                method: "GET"
            }).done(function(options) {
                $.each(options, function(index,value){
                    $("#printer_types").append('<option value="'+index+'">'+value+'</option>');
                })
            }).fail(function() {
                //Não foram encontradas impressoras cadastradas para este tipo
                var msg = "@lang('validation.label_types')";
                alert(msg);
                //$('#msg_excluir').html('<div class="alert alert-info">@lang('infos.print_label_type')</div>');
                //Fecha Modal
                //$('#printModal').modal('toggle');
            });

            //Lista impressoras disponíveis
            //PrintServer TWX
            $.ajax({
                url: "http://localhost:9101/printers",
                method: "POST",
                timeout: 3000
            }).done(function(options) {
                $.each(options['printers'], function(index,value){
                    var key = Object.keys(value)[0];
                    $("#printers").append('<option value="'+value[key]+'">'+key+'</option>');
                })
            }).fail(function(jqXHR, textStatus) {
                var msg = "@lang('validation.print_server')";
                alert(msg);
                $('#msg_excluir').html('<div class="alert alert-info">@lang('infos.print_server') <a href="#">Clique Aqui</a></div>');
                //Fecha Modal
                $('#printModal').modal('toggle');
            });

            

        })


        $('#formPrint').click(function(event){
            
            event.preventDefault();

            printer = $("#printers").val();
            
            //Pega os dados do formulário preenchido (etiquetas, lotes, produtos, etc.)
            //e envia via ajax para impressão
            var formData = $('form').serialize();
            //Primeiro ajax envia o formulário com os dados da etiqueta / documento para realizar a substituição 
            //das variaveis nos layouts
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
                            $('#msg_excluir').html('<div class="alert alert-success">Impressão realizada na fila '+printer+'</div>');
                            //Fecha Modal
                            $('#printModal').modal('toggle');
                        },
                        error: function(){
                             //Mostra mensagem de erro
                             $('#msg_print .alert').remove();
                             $('#msg_print').html('<div class="alert alert-danger">Fila '+printer+' não disponível para impressão.</div>');
                            
                        }
                    });
                }
            });
            

        })
        
    })

</script>
@endsection