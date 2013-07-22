<!DOCTYPE html>
<meta charset="utf-8">

<link href="d3.css" rel="stylesheet" type="text/css">

<style>
#test1 {
  margin: 0;
  padding: 0;
  overflow: none;
}
</style>


<body>

<div id="test1">
  <svg></svg>
</div>

<script src="http://mbostock.github.com/d3/d3.v2.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="nvtooltip.js"></script>
<script src="d3legend.js"></script> 
<script src="d3line.js"></script> 
<script src="d3linewithlegend.js"></script> 
<script>

function log(text) {
  if (console && console.log) console.log(text);
  return text;
}



$(document).ready(function() {
  var margin = {top: 30, right: 10, bottom: 50, left: 60},
      chart = d3LineWithLegend()
                .xAxis.label('Temperature (K)')
                .width(width(margin))
                .height(height(margin))
                .yAxis.label('Chi & ChiT');


  var svg = d3.select('#test1 svg')
      .datum(generateData())

  svg.transition().duration(500)
      .attr('width', width(margin))
      .attr('height', height(margin))
      .call(chart);


  chart.dispatch.on('showTooltip', function(e) {
  var offset = $('#test1').offset(), // { left: 0, top: 0 }
        left = e.pos[0] + offset.left,
        top = e.pos[1] + offset.top,
        formatter = d3.format(".04f");

    var content = '<h3>' + e.series.label + '</h3>' +
                  '<p>' +
                  '<span class="value">[' + e.point[0] + ', ' + formatter(e.point[1]) + ']</span>' +
                  '</p>';

    nvtooltip.show([left, top], content);
  });

  chart.dispatch.on('hideTooltip', function(e) {
    nvtooltip.cleanup();
  });




  $(window).resize(function() {
    var margin = chart.margin();

    chart
      .width(width(margin))
      .height(height(margin));

    d3.select('#test1 svg')
      .attr('width', width(margin))
      .attr('height', height(margin))
      .call(chart);

    });




  function width(margin) {
    var w = $(window).width() - 20;

    return ( (w - margin.left - margin.right - 20) < 0 ) ? margin.left + margin.right + 2 : w;
  }

  function height(margin) {
    var h = $(window).height() - 20;

    return ( h - margin.top - margin.bottom - 20 < 0 ) ? 
              margin.top + margin.bottom + 2 : h;
  }


  //data
  d3.text("upload/chi.txt", fillArrays);
  function fillArrays(){
	var chi = d3.csv.parseRows(unparsedData);
  }
  
  function generateData(){
    var sin = [],
        sin2 = [],
        cos = [],
        cos2 = [],
        r1 = Math.random(),
        r2 = Math.random(),
        r3 = Math.random(),
        r4 = Math.random();

    for (var i = 0; i < 100; i++) {
      sin.push([ i, r1 * Math.sin( r2 +  i / (10 * (r4 + .5) ))]);
      cos.push([ i, r2 * Math.cos( r3 + i / (10 * (r3 + .5) ))]);
      sin2.push([ i, r3 * Math.sin( r1 + i / (10 * (r2 + .5) ))]);
      cos2.push([ i, r4 * Math.cos( r4 + i / (10 * (r1 + .5) ))]);
    }

    return [
      {
        data: sin,
        label: "Chi"
      },
      {
        data: cos,
        label: "Cosine Wave"
      },
      {
        data: sin2,
        label: "ChiT"
      },
      {
        data: cos2,
        label: "Cosine2 Wave"
      }
    ];
  }

});
</script>