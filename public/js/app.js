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
                console.log(ui.item.value);
                $('#' + id).val(ui.item.value);
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


    $('#button-suporte').click(function() {})

});

//Função genérica que cria um gráfico 
function generateGraph(ctx, url) {
    $.ajax({
        url: url,
        async: true,
        dataType: 'json',
        type: "get",
    }).done(function(result) {
        var myChart = new Chart(ctx, {
            type: result.chartType,
            data: {
                labels: result.labels,
                datasets: [{
                    label: 'Quantidade',
                    data: result.data,
                    backgroundColor: result.color,
                    borderColor: result.color,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                title: {
                    display: true,
                    text: result.title
                },
                tooltips: {
                    enabled: false
                },
                pieceLabel: {
                    render: 'value' //show values
                },
                animation: {
                    "duration": 1,
                    "onComplete": function() {
                        var chartInstance = this.chart,
                            ctx = chartInstance.ctx;

                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function(dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function(bar, index) {
                                var data = dataset.data[index];
                                if (result.chartType == 'bar') {
                                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                                } else if (result.chartType == 'line') {
                                    ctx.fillText(data, bar._model.x, bar._model.y - 10);
                                }
                            });
                        });
                    }
                }
            }
        });
    });
}


//Atualiza o usuário logado de 1 em 1 minuto
setInterval(function() {
    $.ajax(APP_URL + "/users/updTime")
        .done(function() {
            //
        });
}, 58000);