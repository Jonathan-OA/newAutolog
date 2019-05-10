$(function() {
    var label_type;
    //Chama ao clicar no botão para abrir a modal
    $('#printModal').on('shown.bs.modal', function() {

        label_type = $('#label_type_code').val();
        var ip = $('#ip_local').val();
        console.log(ip);

        //Carrega impressoras para o tipo de etiqueta
        $.ajax({
            url: "labelLayouts/" + label_type + "/printers",
            method: "GET"
        }).done(function(options) {
            $.each(options, function(index, value) {
                $("#printer_types").append('<option value="' + index + '">' + value + '</option>');
            })
        }).fail(function() {
            //Não foram encontradas impressoras cadastradas para este tipo
            var msg = "@lang('validation.label_types')";
            alert(msg);
            $('#msg_excluir').html('<div class="alert alert-info">@lang('
                infos.print_label_type ')</div>');
            //Fecha Modal
            $('#printModal').modal('toggle');
        });

        //Lista impressoras disponíveis
        $.ajax({
            url: "http://localhost:9101/printers",
            method: "POST",
            timeout: 3000
        }).done(function(options) {
            $.each(options['printers'], function(index, value) {
                var key = Object.keys(value)[0];
                $("#printers").append('<option value="' + value[key] + '">' + key + '</option>');
            })
        }).fail(function(jqXHR, textStatus) {
            var msg = "@lang('validation.print_server')";
            alert(msg);
            $('#msg_excluir').html('<div class="alert alert-info">@lang('
                infos.print_server ') <a href="#">Clique Aqui</a></div>');
            //Fecha Modal
            $('#printModal').modal('toggle');
        });



    })

    //Ao clicar em imprimir, busca os comandos de impressão 
    $('#formPrint').submit(function(event) {
        var printer_type = $('#printer_types').val();
        var printer_name = $('#printers').val();
        var comm;
        //Busca comandos de impressão para o tipo de etiqueta / impressora
        $.ajax({
            url: "labelLayouts/" + label_type + "/" + printer_type + "/commands",
            method: "GET"
        }).done(function(result) {
            if (result['error'] == 1) {
                //Não encontrou os comandos de impressão
                alert(result['msg']);
            } else {
                comm = result[0]['commands'];
                //Chama a rota de impressão no servidor passando como parametro na url o nome e como dado POST os comandos
                $.ajax({
                    url: "http://localhost:9101/printer/" + printer_name,
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
    })



})