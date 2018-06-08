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

    function split(val) {
        return val.split(/,\s*/);
    }

    function extractLast(term) {
        return split(term).pop();
    }

    //Autocomplete
    //Para funcionar em mais de um campo na mesma tela deve seguir a nomenclatura de id:autocomplete1, autocomplete2, etc.
    $('[id^=autocomplete]').bind("keydown", function(event) {
        if (event.keyCode === $.ui.keyCode.TAB &&
            $(this).autocomplete("instance").menu.active) {
            event.preventDefault();
        }
    }).autocomplete({
        minLength: 0,
        source: function(request, response) {
            id = this.element.attr('id');
            campo = this.element.attr('name');
            var table = $('#' + id).attr('table');
            //Valida se este input esta atrelado ao valor de um input anterior para buscar como filtro 
            //Tag: id_dep (Contendo o id do input atrelado)
            //(Ex: Depart -> Deposi)
            try {
                var inputDepend = $('#' + id).attr('id_dep');
                var valDepend = $('#' + inputDepend).val();
                var tableDep = $('#' + inputDepend).attr('table');

            } catch (err) {
                var valDepend = '';
                var tableDep = '';
            }

            //Se o input esta com readonly, não lista as opções
            var attr = $('#' + id).attr("readonly");
            if (typeof attr == typeof undefined || attr === false) {
                $.ajax({
                    url: APP_URL + "/search",
                    dataType: "json",
                    data: {
                        term: extractLast(request.term),
                        table: table,
                        tableDep: tableDep,
                        valDep: valDepend,
                        field: campo
                    },
                    success: function(data) {
                        response(data);
                    }

                });
            }
        },
        select: function(event, ui) {
            //Se possui o  atributo multiple, permite buscar mais de uma opção
            var mult = $('#' + id).attr("multiple");

            if (typeof mult != typeof undefined || mult === true) {
                //Faz os ajustes para multiplos valores
                var terms = split(this.value);
                terms.pop();
                terms.push(ui.item.value);
                // add placeholder to get the comma-and-space at the end
                terms.push("");
                this.value = terms.join(", ");
                return false;
            } else {
                $('#' + id).val(ui.item.code);
            }
            $("[id_dep='" + id + "']").attr("readonly", false);

        }
    }).focus(function() {
        //Ao focar, mostra a listagem completa
        $(this).autocomplete("search");
    }).click(function() {
        //Ao clicar, mostra a listagem completa
        $(this).autocomplete("search");
    });




});

//Atualiza o usuário logado de 1 em 1 minuto
setInterval(function() {
    $.ajax(APP_URL + "/users/updTime")
        .done(function() {
            //
        });
}, 58000);