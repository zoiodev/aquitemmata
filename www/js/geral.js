// $(window).bind("load resize", function () {
//
//     //**** FOOTER _____________________|||
//     var footer = $(".footer");
//     var pos = footer.position();
//     var height = $(window).height();
//     height = height - pos.top;
//     height = height - footer.height();
//     if (height > 0) {
//         height = height-40;
//         footer.fadeIn('fast');
//         footer.css({
//             'margin-top': height + 'px'
//         });
//     }
//
//
//     //**** AUTO COMPLETE GOOGLE _____________________|||
//     ajusteDivAutoCompleteGoogle()
// });

$(window).bind("load", function () {
    ///**** Botões de escolha por tipo
    ativarBotaoTipo('');

    $('.botoes-escolha').click(function(event) {
        $('.botoes-escolha').removeClass('active');
        $(this).addClass('active');

        if ($(this).attr('id') == 'bt_municipio') {
            $('.campo-busca-home').attr('placeholder', 'Escreva o nome do seu município');
        } else {
            $('.campo-busca-home').attr('placeholder', 'Escreva o número do seu CEP');
        }

    });


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


    ///**** Botão DESCOBRIR
    $('.descobrir').bind('mouseover click', function(event) {
        // console.log('teste');
        /* Act on the event */
        var imgHeight = 78;
        var numImgs = 8;
        var cont = 0;

        // console.log('INDO_________________________');

        var animation = setInterval(function(){
            var position =  -1 * (cont*imgHeight);
            // console.log(position);
            $('.descobrir').css('background-position-y', position);

            cont++;
            if(cont == numImgs){
                clearInterval(animation);
            }
        },20);
    });


    $('.descobrir').bind('mouseout', function(event) {
        // console.log('VOLTANDO_________________________');

        // $('.descobrir').css('background-position-y', 'bottom');

        /* Act on the event */
        var imgHeight = 78;
        var numImgs = 8;
        var cont = 7;

        var animation = setInterval(function(){
            var position = -1 * (cont*imgHeight);
            // console.log(position);
            $('.descobrir').css('background-position-y', position);

            cont--;
            if(cont == 0){
                clearInterval(animation);
            }
        },10);
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
    $('.botoes-escolha').removeClass('active');

    var temNumeros = texto.match(/\d+/g);

    if (temNumeros != null) {
        $('#bt_bairro').addClass('active');
    } else {
        $('#bt_municipio').addClass('active');
    }
}
