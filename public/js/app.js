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


    //Autocomplete
    $('#autocomplete').autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "pallets/datatable",
                dataType: "jsonp",
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            log("Selected: " + ui.item.value + " aka " + ui.item.id);
        }
    });
});

//Atualiza o usuário logado de 1 em 1 minuto
setInterval(function() {
    $.ajax("users/updTime")
        .done(function() {
            //
        });
}, 58000);