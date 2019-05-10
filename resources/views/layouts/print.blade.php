<!-- Layout da modal para realizar impressões -->
<!-- Caso a variável $print seja verdadeira, envia o conteúdo de impressao ($filePrint) para a impressora -->
@if(!empty($print) && $print == true)
<div class="modal-dialog" role="document" onload="printLabel()">
@else
<div class="modal-dialog" role="document">
@endif
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
                    {!! Form::submit(Lang::get('buttons.print'), ['class' => 'btn btn-primary']) !!}
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
            console.log(label_type);

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

        //Ao clicar em imprimir, busca os comandos de impressão 
        function printLabel(){
            var filePrint = "{{((empty($filePrint))?'':$filePrint)}}";
            console.log(filePrint);
            var printer_type = $('#printer_types').val();
            var printer_name = $('#printers').val();
            var comm;
            //Busca comandos de impressão para o tipo de etiqueta / impressora
            $.ajax({
                url: "{!! URL::to('labelLayouts/"+label_type+"/"+printer_type+"/commands') !!}",
                method: "GET"
            }).done(function(result) {
                if(result['error'] == 1){
                    //Não encontrou os comandos de impressão
                    alert(result['msg']);
                }else{
                    comm = result[0]['commands'];
                    //Chama a rota de impressão no servidor passando como parametro na url o nome e como dado POST os comandos
                    $.ajax({
                        url: "http://localhost:9101/printer/"+printer_name,
                        method: "POST",
                        data: comm
                    }).done(function(result) {
                        //Falha na impressão
                        var msg = "@lang('validation.label_print')";
                        //Fecha Modal 
                        $('#printModal').modal('toggle');
                        console.log(result);
                    })
                }
            })
            event.preventDefault();
        }
        

        
    })

</script>
@endsection