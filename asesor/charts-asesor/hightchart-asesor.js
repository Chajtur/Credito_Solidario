/**
 * Easing function from https://github.com/danro/easing-js/blob/master/easing.js
 */
Math.easeOutBounce = function (pos) {
    if ((pos) < (1 / 2.75)) {
        return (7.5625 * pos * pos);
    }
    if (pos < (2 / 2.75)) {
        return (7.5625 * (pos -= (1.5 / 2.75)) * pos + 0.75);
    }
    if (pos < (2.5 / 2.75)) {
        return (7.5625 * (pos -= (2.25 / 2.75)) * pos + 0.9375);
    }
    return (7.5625 * (pos -= (2.625 / 2.75)) * pos + 0.984375);
};


$(function () {
    $('#highchart5').highcharts({
        chart: {
            type: 'column',
            backgroundColor: '#ededed'
        },
        xAxis: {
            categories: ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes']
        },
        yAxis: {
            min: 0,
            max: 100,
            title: {
                text: 'Creditos (%)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },

        plotOptions: {
            series: {
                animation: {
                    duration: 5000,
                    easing: 'easeOutBounce'
                }
            }
        },

        series: [
            {
                name: 'credito 1',
                color: '#2196F3',
                data: [29.9, 71.5, 16.4, 29.2, 71]
            },
            {
                name: 'credito 2',
                color: '#9C27B0',
                data: [40, 50, 80, 20, 78]
                 }
                ]
    });
});
