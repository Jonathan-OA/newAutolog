//Funções Relacionadas ao Layout Base
$( document ).ready(function() {
    //Esconde / Mostra Menu
    $('#button_menu').click(function(){
        $('#lay_menu_op').toggle();
        if ($('#lay_menu_op').is(':visible')){
            $(this).css('menu');
        }
    })



});