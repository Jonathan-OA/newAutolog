//Funções Relacionadas ao Layout Base
$(document).ready(function() {

    //Esconde / Mostra Menu
    $('#button_menu').click(function() {
        $('#lay_menu_op').toggle();
        if ($('#lay_menu_op').is(':visible')) {
            $(this).css('menu');
            //Diminui largura do painel
            $('#ctrl_rsp').addClass('col-md-10');
        } else {
            //Aumenta largura do painel
            $('#ctrl_rsp').removeClass('col-md-10');
        }

        //Recarrega colunas datatable, caso exista (corrigir layout)
        if (table) {
            table.columns.adjust().draw();
        }

    })

    var id = "";

    //Autocomplete
    //Para funcionar em mais de um campo na mesma tela deve seguir a nomenclatura autocomplete1, autocomplete2, etc.

    $('[id^=autocomplete]').autocomplete({
        source: function(request, response) {
            id = this.element.attr('id');
            var table = $('#' + id).attr('table');
            $.ajax({
                url: APP_URL + "/search",
                dataType: "json",
                data: {
                    term: request.term,
                    table: table
                },
                success: function(data) {
                    response(data);
                }

            });
        },
        minLength: 1,
        select: function(event, ui) {
            $('#' + id).val(ui.item.code);

        }
    });
});

//Atualiza o usuário logado de 1 em 1 minuto
setInterval(function() {
    $.ajax(APP_URL + "/users/updTime")
        .done(function() {
            //
        });
}, 58000);