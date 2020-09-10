// CHART SPLINE
// ----------------------------------- 
(function(window, document, $, undefined){

  $(function(){

    var data = [{
      "label": "Locações POS realizadas",
      "color": "#1f92fe",
      "data": [
        ["1", parseInt($("#locacoes_01072016").val())],
        ["2", parseInt($("#locacoes_02072016").val())],
        ["3", parseInt($("#locacoes_03072016").val())],
        ["4", parseInt($("#locacoes_04072016").val())],
        ["5", parseInt($("#locacoes_05072016").val())],
        ["6", parseInt($("#locacoes_06072016").val())],
        ["7", parseInt($("#locacoes_07072016").val())],
        ["8", parseInt($("#locacoes_08072016").val())],
        ["9", parseInt($("#locacoes_09072016").val())],
        ["10", parseInt($("#locacoes_10072016").val())],
        ["11", parseInt($("#locacoes_11072016").val())],
        ["12", parseInt($("#locacoes_12072016").val())],
        ["13", parseInt($("#locacoes_13072016").val())],
        ["14", parseInt($("#locacoes_14072016").val())],
        ["15", parseInt($("#locacoes_15072016").val())],
        ["16", parseInt($("#locacoes_16072016").val())],
        ["17", parseInt($("#locacoes_17072016").val())],
        ["18", parseInt($("#locacoes_18072016").val())],
        ["19", parseInt($("#locacoes_19072016").val())],
        ["20", parseInt($("#locacoes_20072016").val())],
        ["21", parseInt($("#locacoes_21072016").val())],
        ["22", parseInt($("#locacoes_22072016").val())],
        ["23", parseInt($("#locacoes_23072016").val())],
        ["24", parseInt($("#locacoes_24072016").val())],
        ["25", parseInt($("#locacoes_25072016").val())],
        ["26", parseInt($("#locacoes_26072016").val())],
        ["27", parseInt($("#locacoes_27072016").val())],
        ["28", parseInt($("#locacoes_28072016").val())],
        ["29", parseInt($("#locacoes_29072016").val())],
        ["30", parseInt($("#locacoes_30072016").val())],
        ["31", parseInt($("#locacoes_31072016").val())]
      ]
    }];

    var data_vendas = [{
      "label": "Transações realizadas",
      "color": "#1f92fe",
      "data": [
        ["1", parseInt($("#vendas_01072016").val())],
        ["2", parseInt($("#vendas_02072016").val())],
        ["3", parseInt($("#vendas_03072016").val())],
        ["4", parseInt($("#vendas_04072016").val())],
        ["5", parseInt($("#vendas_05072016").val())],
        ["6", parseInt($("#vendas_06072016").val())],
        ["7", parseInt($("#vendas_07072016").val())],
        ["8", parseInt($("#vendas_08072016").val())],
        ["9", parseInt($("#vendas_09072016").val())],
        ["10", parseInt($("#vendas_10072016").val())],
        ["11", parseInt($("#vendas_11072016").val())],
        ["12", parseInt($("#vendas_12072016").val())],
        ["13", parseInt($("#vendas_13072016").val())],
        ["14", parseInt($("#vendas_14072016").val())],
        ["15", parseInt($("#vendas_15072016").val())],
        ["16", parseInt($("#vendas_16072016").val())],
        ["17", parseInt($("#vendas_17072016").val())],
        ["18", parseInt($("#vendas_18072016").val())],
        ["19", parseInt($("#vendas_19072016").val())],
        ["20", parseInt($("#vendas_20072016").val())],
        ["21", parseInt($("#vendas_21072016").val())],
        ["22", parseInt($("#vendas_22072016").val())],
        ["23", parseInt($("#vendas_23072016").val())],
        ["24", parseInt($("#vendas_24072016").val())],
        ["25", parseInt($("#vendas_25072016").val())],
        ["26", parseInt($("#vendas_26072016").val())],
        ["27", parseInt($("#vendas_27072016").val())],
        ["28", parseInt($("#vendas_28072016").val())],
        ["29", parseInt($("#vendas_29072016").val())],
        ["30", parseInt($("#vendas_30072016").val())],
        ["31", parseInt($("#vendas_31072016").val())]
      ]
    }];

    var options = {
      series: {
          lines: {
              show: true
          },
          points: {
              show: true,
              radius: 4
          },
          splines: {
              show: false,
              tension: 0,
              lineWidth: 1,
              fill: 0.5
          }
      },
      grid: {
          borderColor: '#eee',
          borderWidth: 1,
          hoverable: true,
          backgroundColor: '#fcfcfc'
      },
      tooltip: true,
      tooltipOpts: {
          content: function (label, x, y) { return x + ' : ' + y; }
      },
      xaxis: {
          tickColor: '#fcfcfc',
          mode: 'categories'
      },
      yaxis: {
          min: 0,
          minTickSize: 1,
          tickColor: '#eee',
          //position: 'right' or 'left',
          tickFormatter: function (v) {
              return v/* + ' visitors'*/;
          }
      },
      shadowSize: 0
    };

    var chart = $('.chart-spline');
    if(chart.length)
      $.plot(chart, data, options);

    var chart_vendas = $('.chart-spline-vendas');
    if(chart_vendas.length)
      $.plot(chart_vendas, data_vendas, options);

  });

})(window, document, window.jQuery);

// CHART AREA
// ----------------------------------- 
(function(window, document, $, undefined){

  $(function(){

    var data = [{
      "label": "Recurrent",
      "color": "#7dc7df",
      "data": [
        ["1", 13],
        ["2", 44],
        ["3", 44],
        ["4", 27],
        ["5", 38],
        ["6", 11],
        ["7", 39],
        ["8", 39],
        ["9", 39],
        ["10", 39],
        ["11", 39],
        ["12", 39],
        ["13", 39],
        ["14", 39],
        ["15", 39],
        ["16", 39],
        ["17", 39],
        ["18", 39],
        ["19", 39],
        ["20", 39],
        ["21", 9],
        ["22", 39],
        ["23", 39],
        ["24", 39],
        ["25", 39],
        ["26", 39],
        ["27", 39],
        ["28", 39],
        ["29", 39],
        ["30", 39],
        ["31", 39]
      ]
    }];

    var options = {
                    series: {
                        lines: {
                            show: true,
                            fill: 0.8
                        },
                        points: {
                            show: true,
                            radius: 4
                        }
                    },
                    grid: {
                        borderColor: '#eee',
                        borderWidth: 1,
                        hoverable: true,
                        backgroundColor: '#fcfcfc'
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: function (label, x, y) { return x + ' : ' + y; }
                    },
                    xaxis: {
                        tickColor: '#fcfcfc',
                        mode: 'categories'
                    },
                    yaxis: {
                        min: 0,
                        tickColor: '#eee',
                        // position: 'right' or 'left'
                        tickFormatter: function (v) {
                            return v + ' visitors';
                        }
                    },
                    shadowSize: 0
                };

    var chart = $('.chart-area');
    if(chart.length)
      $.plot(chart, data, options);

  });

})(window, document, window.jQuery);

// CHART BAR
// ----------------------------------- 
(function(window, document, $, undefined){

  $(function(){

    var data = [{
      "label": "Sales",
      "color": "#9cd159",
      "data": [
        ["Jan", 27],
        ["Feb", 82],
        ["Mar", 56],
        ["Apr", 14],
        ["May", 28],
        ["Jun", 77],
        ["Jul", 23],
        ["Aug", 49],
        ["Sep", 81],
        ["Oct", 20]
      ]
    }];

    var options = {
                    series: {
                        bars: {
                            align: 'center',
                            lineWidth: 0,
                            show: true,
                            barWidth: 0.6,
                            fill: 0.9
                        }
                    },
                    grid: {
                        borderColor: '#eee',
                        borderWidth: 1,
                        hoverable: true,
                        backgroundColor: '#fcfcfc'
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: function (label, x, y) { return x + ' : ' + y; }
                    },
                    xaxis: {
                        tickColor: '#fcfcfc',
                        mode: 'categories'
                    },
                    yaxis: {
                        // position: 'right' or 'left'
                        tickColor: '#eee'
                    },
                    shadowSize: 0
                };

    var chart = $('.chart-bar');
    if(chart.length)
      $.plot(chart, data, options);

  });

})(window, document, window.jQuery);


// CHART BAR STACKED
// ----------------------------------- 
(function(window, document, $, undefined){

  $(function(){

    var data = [{
      "label": "Tweets",
      "color": "#51bff2",
      "data": [
        ["Jan", 56],
        ["Feb", 81],
        ["Mar", 97],
        ["Apr", 44],
        ["May", 24],
        ["Jun", 85],
        ["Jul", 94],
        ["Aug", 78],
        ["Sep", 52],
        ["Oct", 17],
        ["Nov", 90],
        ["Dec", 62]
      ]
    }, {
      "label": "Likes",
      "color": "#4a8ef1",
      "data": [
        ["Jan", 69],
        ["Feb", 135],
        ["Mar", 14],
        ["Apr", 100],
        ["May", 100],
        ["Jun", 62],
        ["Jul", 115],
        ["Aug", 22],
        ["Sep", 104],
        ["Oct", 132],
        ["Nov", 72],
        ["Dec", 61]
      ]
    }, {
      "label": "+1",
      "color": "#f0693a",
      "data": [
        ["Jan", 29],
        ["Feb", 36],
        ["Mar", 47],
        ["Apr", 21],
        ["May", 5],
        ["Jun", 49],
        ["Jul", 37],
        ["Aug", 44],
        ["Sep", 28],
        ["Oct", 9],
        ["Nov", 12],
        ["Dec", 35]
      ]
    }];

    var datav2 = [{
      "label": "Pending",
      "color": "#9289ca",
      "data": [
        ["Pj1", 86],
        ["Pj2", 136],
        ["Pj3", 97],
        ["Pj4", 110],
        ["Pj5", 62],
        ["Pj6", 85],
        ["Pj7", 115],
        ["Pj8", 78],
        ["Pj9", 104],
        ["Pj10", 82],
        ["Pj11", 97],
        ["Pj12", 110],
        ["Pj13", 62]
      ]
    }, {
      "label": "Assigned",
      "color": "#7266ba",
      "data": [
        ["Pj1", 49],
        ["Pj2", 81],
        ["Pj3", 47],
        ["Pj4", 44],
        ["Pj5", 100],
        ["Pj6", 49],
        ["Pj7", 94],
        ["Pj8", 44],
        ["Pj9", 52],
        ["Pj10", 17],
        ["Pj11", 47],
        ["Pj12", 44],
        ["Pj13", 100]
      ]
    }, {
      "label": "Completed",
      "color": "#564aa3",
      "data": [
        ["Pj1", 29],
        ["Pj2", 56],
        ["Pj3", 14],
        ["Pj4", 21],
        ["Pj5", 5],
        ["Pj6", 24],
        ["Pj7", 37],
        ["Pj8", 22],
        ["Pj9", 28],
        ["Pj10", 9],
        ["Pj11", 14],
        ["Pj12", 21],
        ["Pj13", 5]
      ]
    }];

    var options = {
                    series: {
                        stack: true,
                        bars: {
                            align: 'center',
                            lineWidth: 0,
                            show: true,
                            barWidth: 0.6,
                            fill: 0.9
                        }
                    },
                    grid: {
                        borderColor: '#eee',
                        borderWidth: 1,
                        hoverable: true,
                        backgroundColor: '#fcfcfc'
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: function (label, x, y) { return x + ' : ' + y; }
                    },
                    xaxis: {
                        tickColor: '#fcfcfc',
                        mode: 'categories'
                    },
                    yaxis: {
                        // position: 'right' or 'left'
                        tickColor: '#eee'
                    },
                    shadowSize: 0
                };

    var chart = $('.chart-bar-stacked');
    if(chart.length)
      $.plot(chart, data, options);

    var chartv2 = $('.chart-bar-stackedv2');
    if(chartv2.length)
      $.plot(chartv2, datav2, options);

  });

})(window, document, window.jQuery);

// CHART DONUT
// ----------------------------------- 
(function(window, document, $, undefined){

  $(function(){

    var data = [ { "color" : "#39C558",
        "data" : 60,
        "label" : "Coffee"
      },
      { "color" : "#00b4ff",
        "data" : 90,
        "label" : "CSS"
      },
      { "color" : "#FFBE41",
        "data" : 50,
        "label" : "LESS"
      },
      { "color" : "#ff3e43",
        "data" : 80,
        "label" : "Jade"
      },
      { "color" : "#937fc7",
        "data" : 116,
        "label" : "AngularJS"
      }
    ];

    var options = {
                    series: {
                        pie: {
                            show: true,
                            innerRadius: 0.5 // This makes the donut shape
                        }
                    }
                };

    var chart = $('.chart-donut');
    if(chart.length)
      $.plot(chart, data, options);

  });

})(window, document, window.jQuery);

// CHART LINE
// ----------------------------------- 
(function(window, document, $, undefined){

  $(function(){

    var data = [{
        "label": "Complete",
        "color": "#5ab1ef",
        "data": [
            ["Jan", 188],
            ["Feb", 183],
            ["Mar", 185],
            ["Apr", 199],
            ["May", 190],
            ["Jun", 194],
            ["Jul", 194],
            ["Aug", 184],
            ["Sep", 74]
        ]
    }, {
        "label": "In Progress",
        "color": "#f5994e",
        "data": [
            ["Jan", 153],
            ["Feb", 116],
            ["Mar", 136],
            ["Apr", 119],
            ["May", 148],
            ["Jun", 133],
            ["Jul", 118],
            ["Aug", 161],
            ["Sep", 59]
        ]
    }, {
        "label": "Cancelled",
        "color": "#d87a80",
        "data": [
            ["Jan", 111],
            ["Feb", 97],
            ["Mar", 93],
            ["Apr", 110],
            ["May", 102],
            ["Jun", 93],
            ["Jul", 92],
            ["Aug", 92],
            ["Sep", 44]
        ]
    }];

    var options = {
                    series: {
                        lines: {
                            show: true,
                            fill: 0.01
                        },
                        points: {
                            show: true,
                            radius: 4
                        }
                    },
                    grid: {
                        borderColor: '#eee',
                        borderWidth: 1,
                        hoverable: true,
                        backgroundColor: '#fcfcfc'
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: function (label, x, y) { return x + ' : ' + y; }
                    },
                    xaxis: {
                        tickColor: '#eee',
                        mode: 'categories'
                    },
                    yaxis: {
                        // position: 'right' or 'left'
                        tickColor: '#eee'
                    },
                    shadowSize: 0
                };

    var chart = $('.chart-line');
    if(chart.length)
      $.plot(chart, data, options);

  });

})(window, document, window.jQuery);


// CHART PIE
// ----------------------------------- 
(function(window, document, $, undefined){

  $(function(){

    var data = [{
      "label": "jQuery",
      "color": "#4acab4",
      "data": 30
    }, {
      "label": "CSS",
      "color": "#ffea88",
      "data": 40
    }, {
      "label": "LESS",
      "color": "#ff8153",
      "data": 90
    }, {
      "label": "SASS",
      "color": "#878bb6",
      "data": 75
    }, {
      "label": "Jade",
      "color": "#b2d767",
      "data": 120
    }];

    var options = {
                    series: {
                        pie: {
                            show: true,
                            innerRadius: 0,
                            label: {
                                show: true,
                                radius: 0.8,
                                formatter: function (label, series) {
                                    return '<div class="flot-pie-label">' +
                                    //label + ' : ' +
                                    Math.round(series.percent) +
                                    '%</div>';
                                },
                                background: {
                                    opacity: 0.8,
                                    color: '#222'
                                }
                            }
                        }
                    }
                };

    var chart = $('.chart-pie');
    if(chart.length)
      $.plot(chart, data, options);

  });

})(window, document, window.jQuery);
