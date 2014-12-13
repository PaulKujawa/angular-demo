$(function() { /* http://www.chartjs.org/docs/#doughnut-pie-chart */
    var ctx         = $("#macroChart").get(0).getContext("2d"),
        kcalSpan    = $('#kcalSpan'),
        macros      = $('#ingredientList');

    var data = [ /* highlight = rgb +20 */
        {
            value: macros.data('carbs'),
            color: "#3C948B",
            highlight: "#50A89F",
            label: "Carbs (gr)"
        },
        {
            value: macros.data('protein'),
            color: "#FDB45C",
            highlight: "#FFC866",
            label: "Protein (gr)"
        },
        {
            value: macros.data('fat'),
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Fat (gr)"
        }
    ];
    //


    var macroChart = new Chart(ctx).Doughnut(data, {
        tooltipFillColor: "rgba(20,20,20,0.8)",
        tooltipTitleFontColor: "#777",
        animationSteps: 300
    });

    kcalSpan
        .fadeIn(4000)
        .tooltip();
});