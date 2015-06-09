$(document).ready(function() {
    $('.slide-ano').noUiSlider({
        start: 2013,
        snap: true,
        range: {
            'min': 2012,
            '33%': 2013,
            '66%': 2014,
            'max': 2015
        }
    });

    $('.slide-ano').noUiSlider_pips({
        mode: 'steps',
        values: [2012, 2015],
        density: 10,
        format: wNumb({
            decimals: 0,
            prefix: ''
        })
    });

    $('.slide-ano').Link('lower').to('-inline-', function ( value ) {
        $(this).html(parseInt(value));
        $('#slider_ano').val(parseInt(value));
    });
});
