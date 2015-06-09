$(document).ready(function(){
    // ///**** Botões de escolha por tipo
    // ativarBotaoTipo('');
    //
    // $('.botoes-busca-home').click(function(event) {
    //     $('.botoes-busca-home').removeClass('active');
    //     $(this).addClass('active');
    //
    //     if ($(this).attr('id') == 'bt_municipio') {
    //         $('.campo-busca-home').attr('placeholder', 'Escreva o nome do seu município');
    //     } else {
    //         $('.campo-busca-home').attr('placeholder', 'Escreva o número do seu CEP');
    //     }
    //
    // });


    ///**** Campo de busca HOME
    $('.campo-busca-home').keyup(function(event) {
        ativarBotaoTipo($(this).val());
    });

    $('.campo-busca-home').keypress(function(event) {
        ajusteDivAutoCompleteGoogle(0);
    });
    $('.campo-busca-home').keydown(function(e) {
        switch (e.keyCode) {
            case 8:  // Backspace
                ajusteDivAutoCompleteGoogle(1);
        }
    });



});

function ajusteDivAutoCompleteGoogle(x) {
    var largura_div = $('.pac-container').outerWidth();
    var largura_campo = $('.campo-busca-home').outerWidth();


    if (!(largura_div == largura_campo)) {
        $('.pac-container').outerWidth( $('.campo-busca-home').outerWidth() + x );
    }
}


function ativarBotaoTipo(texto) {
    $('.botoes-busca-home').removeClass('active');

    var temNumeros = texto.match(/\d+/g);

    if (temNumeros != null) {
        $('#bt_bairro').addClass('active');
    } else {
        $('#bt_municipio').addClass('active');
    }
}
