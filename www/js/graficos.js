$(document).ready(function() {
    // PIZZA
    // *********************************************
    var options_pizza = {
        responsive:true,
        animationEasing: "easeOutQuad",
        tooltipFillColor: "rgba(0,0,0,0.8)",
        tooltipFontFamily: "'Gotham-Light'",
        segmentShowStroke : false,
    };

    var data_pizza = [
        {
            value: 13,
            color: "#FFDE00",
            highlight: "#FFDE00",
            label: "Caatinga"
        },
        {
            value: 85,
            color:"#99BC3A",
            highlight: "#99BC3A",
            label: "Mata Atlântica"
        },
        {
            value: 3,
            color: "#919191",
            highlight: "#919191",
            label: "Mangue"
        }
    ]

    var ctx_pizza = document.getElementById("pizza").getContext("2d");
    var PizzaChart_pizza = new Chart(ctx_pizza).Doughnut(data_pizza, options_pizza);

    for (var i = 0; i < data_pizza.length; i++) {
        $('ul.legenda-pizza').append('<li><div class="radius-full left" style="background-color: '+ data_pizza[i]['color'] +'"></div> '+ data_pizza[i]['label'] +'</li>');
    }
    // *********************************************
    // / PIZZA



    // LINHAS
    // *********************************************
    var data_linhas = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [65, 59, 80, 81, 56, 55, 40]
            },
            {
                label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [28, 48, 40, 19, 86, 27, 90]
            }
        ]
    };
    var ctx_linhas = document.getElementById("linhas").getContext("2d");
    var myLineChart_linhas = new Chart(ctx_linhas).Line(data_linhas, options_pizza);
    // *********************************************
    // / LINHAS
});
