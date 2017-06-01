@extends('layouts.app')
@section('content')
<style>
.chart {
    min-width: 320px;
    max-width: 800px;
    height: 220px;
    margin: 0 auto;
}
</style>
<!-- http://doc.jsfiddle.net/use/hacks.html#css-panel-hack -->
<meta name="viewport" content="width=device-width, initial-scale=1" />
<script src="{{asset('js/highcharts.js')}}"></script>
<script src="{{asset('js/exporting.js')}}"></script>

<div id="container"></div>
<div id="containerr"></div>
<script>
$(function () {
        $('#container').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Logueos Por Usuario'
            },
            tooltip: {
              pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          plotOptions: {
              pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                      enabled: false
                  },
                  showInLegend: true
              }
          },
          series: [{
              name: 'logueo',
              colorByPoint: true,
              data: [
                @foreach($usuarios as $usuario)
                @if($usuario->roles->first()->name != "adm")
                {
                  name: '{{$usuario->name}}',
                  y: {{$usuario->registros()->count()}}
              },
              @endif
              @endforeach
            ]
          }]
      });
  });
  $('#containerr').bind('mousemove touchmove touchstart', function (e) {
      var chart,
          point,
          i,
          event;

      for (i = 0; i < Highcharts.charts.length; i = i + 1) {
          chart = Highcharts.charts[i];
          event = chart.pointer.normalize(e.originalEvent); // Find coordinates within the chart
          point = chart.series[0].searchPoint(event, true); // Get the hovered point

          if (point) {
              point.highlight(e);
          }
      }
  });
  /**
   * Override the reset function, we don't need to hide the tooltips and crosshairs.
   */
  Highcharts.Pointer.prototype.reset = function () {
      return undefined;
  };

  /**
   * Highlight a point by showing tooltip, setting hover state and draw crosshair
   */
  Highcharts.Point.prototype.highlight = function (event) {
      this.onMouseOver(); // Show the hover marker
      this.series.chart.tooltip.refresh(this); // Show the tooltip
      this.series.chart.xAxis[0].drawCrosshair(event, this); // Show the crosshair
  };

  /**
   * Synchronize zooming through the setExtremes event handler.
   */
  function syncExtremes(e) {
      var thisChart = this.chart;

      if (e.trigger !== 'syncExtremes') { // Prevent feedback loop
          Highcharts.each(Highcharts.charts, function (chart) {
              if (chart !== thisChart) {
                  if (chart.xAxis[0].setExtremes) { // It is null while updating
                      chart.xAxis[0].setExtremes(e.min, e.max, undefined, false, { trigger: 'syncExtremes' });
                  }
              }
          });
      }
  }

  // Get the data. The contents of the data file can be viewed at
  // https://github.com/highcharts/highcharts/blob/master/samples/data/activity.json
  $.getJSON('https://www.highcharts.com/samples/data/jsonp.php?filename=activity.json&callback=?', function (activity) {
      $.each(activity.datasets, function (i, dataset) {

          // Add X values
          dataset.data = Highcharts.map(dataset.data, function (val, j) {
              return [activity.xData[j], val];
          });

          $('<div class="chart">')
              .appendTo('#containerr')
              .highcharts({
                  chart: {
                      marginLeft: 40, // Keep all charts left aligned
                      spacingTop: 20,
                      spacingBottom: 20
                  },
                  title: {
                      text: dataset.name,
                      align: 'left',
                      margin: 0,
                      x: 30
                  },
                  credits: {
                      enabled: false
                  },
                  legend: {
                      enabled: false
                  },
                  xAxis: {
                      crosshair: true,
                      events: {
                          setExtremes: syncExtremes
                      },
                      labels: {
                          format: '{value} km'
                      }
                  },
                  yAxis: {
                      title: {
                          text: null
                      }
                  },
                  tooltip: {
                      positioner: function () {
                          return {
                              x: this.chart.chartWidth - this.label.width, // right aligned
                              y: -1 // align to title
                          };
                      },
                      borderWidth: 0,
                      backgroundColor: 'none',
                      pointFormat: '{point.y}',
                      headerFormat: '',
                      shadow: false,
                      style: {
                          fontSize: '18px'
                      },
                      valueDecimals: dataset.valueDecimals
                  },
                  series: [{
                      data: dataset.data,
                      name: dataset.name,
                      type: dataset.type,
                      color: Highcharts.getOptions().colors[i],
                      fillOpacity: 0.3,
                      tooltip: {
                          valueSuffix: ' ' + dataset.unit
                      }
                  }]
              });
      });
  });
    </script>
@endsection
