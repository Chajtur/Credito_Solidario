////////////////////// Script to Load c3 Chart for Asesor Dashboard //////////////////////////////

$(function () {
    var chartt = c3.generate({
    bindto: '#chart2',
    data: {
      columns: [
        ['data1', 30, 200, 100, 400, 150, 250],
        ['data2', 50, 20, 10, 40, 15, 25]
      ],
      axes: {
        data2: 'y2'
      },
      types: {
        data2: 'bar' // ADD
      }
    },
        color: {
        pattern: ['#2962FF', '#F44336']
    },
    transition: {
        duration: 1500
    },
    axis: {
      y: {
        label: {
          text: 'Y Label',
          position: 'outer-middle'
        }
      },
      y2: {
        show: true,
        label: {
          text: 'Y2 Label',
          position: 'outer-middle'
        }
      }
    }
});
});

///////////////////////////////////////////////////// Chart pie for the second card ////////////////////////////////////
var chartCard1 = null;
var chart = null;
$(function () {

        chart = c3.generate({
        bindto: '#chartPie2',
        data: {
            // iris data from R
            columns: [
            ["setosa", 100],


        ],
            type: 'donut',

        },
        color: {
            pattern: ['#bdbdbd', '#00BCD4']
        },
        size: {
            height: 250
        },
        transition: {
            duration: 1500
        },
        donut: {
            title: 'Title'
        }
    });

    setTimeout(function () {
        chart.load({
            columns: [
            ["setosa", 35],
            ["versicolor", 65],

        ]
        });
    }, 1500);

});

function reloapie2(updatedata) {
  chart.load({
        columns: [
            ["setosa", 50],
            ["versicolor", 50],

        ]
    }); 
};



///////////////////////////////////////////////////// Chart pie for the first card ////////////////////////////////////
var chartCard1 = null;
$(function () {

    chartCard1 = c3.generate({
        bindto: '#chart1',
        data: {
            // iris data from R
            columns: [
            ["setosa", 100],


        ],
            type: 'donut',

        },
        color: {
            pattern: ['#bdbdbd', '#6200ea']
        },
        size: {
            height: 250
        },
        transition: {
            duration: 1500
        },
        donut: {
            title: 'Title'
        }
    });

    setTimeout(function () {
        chartCard1.load({
            columns: [
            ["setosa", 30],
            ["versicolor", 70],

        ]
        });
    }, 1500);

});
//////////////////////Funtion to Re-Load data for the first chart of card 1 ////////////////
function reloapie1(updatedata) {
  chartCard1.load({
        columns: [
            ["setosa", 35],
            ["versicolor", 65],

        ]
    }); 
};

//////////////////////////////////////////////// chart de media luna for the SideNav ////////////////////////////////

$(function () {
    var chart = c3.generate({
        bindto: '#chart4',
        data: {
            columns: [
            ['data', 0]
        ],
            type: 'gauge',
            onclick: function (d, i) {
                console.log("onclick", d, i);
            },
            onmouseover: function (d, i) {
                console.log("onmouseover", d, i);
            },
            onmouseout: function (d, i) {
                console.log("onmouseout", d, i);
            }
        },
        gauge: {
            //        label: {
            //            format: function(value, ratio) {
            //                return value;
            //            },
            //            show: false // to turn off the min/max labels.
            //        },
            //    min: 0, // 0 is default, //can handle negative min e.g. vacuum / voltage / current flow / rate of change
            //    max: 100, // 100 is default
            //    units: ' %',
            //    width: 39 // for adjusting arc thickness
        },
        color: {
            pattern: ['#FF0000', '#0288D1', '#F6C600', '#60B044'], // the three color levels for the percentage values.
            threshold: {
                //            unit: 'value', // percentage is default
                //            max: 200, // 100 is default
                values: [30, 60, 90, 100]
            }
        },
        size: {
            height: 100
        },
        transition: {
            duration: 1000
        }
    });


    setTimeout(function () {
        chart.load({
            columns: [['data', 100]]
        });
    }, 2000);
    setTimeout(function () {
        chart.load({
            columns: [['data', 30]]
        });
    }, 3000);

});

