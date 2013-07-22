<html>
 
<head>
 
<script type="text/javascript" src="d3.v3/d3.v3.min.js"></script>
 
<script type="text/javascript">
 
 window.onload = function()
 {
  d3.text("upload/temperature.csv", function(unparsedData)
  {
   var data = d3.csv.parseRows(unparsedData);
	
   //Create the SVG graph.
   var svg = d3.select("body").append("svg").attr("width", "100%").attr("height", "100%");
  
   //Add data to the graph and call enter.
   var dataEnter = svg.selectAll("rect").data(data).enter();

   //The height of the graph (without text).
   var graphHeight = 450;
    
   //The width of each bar.
   var barWidth = 80;
    
   //The distance between each bar.
   var barSeparation = 10;
    
   //The maximum value of the data.
   var maxData = 105;
    
    
    
   //The actual horizontal distance from drawing one bar rectangle to drawing the next.
   var horizontalBarDistance = barWidth + barSeparation;
    
    
   //The horizontal and vertical offsets of the text that displays each bar's value.
   var textXOffset = horizontalBarDistance / 2 - 12;
   var textYOffset = 20;
    
    
   //The value to multiply each bar's value by to get its height.
   var barHeightMultiplier = graphHeight / maxData;
    
   //The actual Y position of every piece of text.
   var textYPosition = graphHeight + textYOffset;
    
    
    
   //Draw the bars.
   dataEnter.append("rect").attr("x", function(d, i)
   {
    return i * horizontalBarDistance;
   }).attr("y", function(d)
   {
    return graphHeight - d * barHeightMultiplier;
   }).attr("width", function(d)
   {
    return barWidth;
   }).attr("height", function(d)
   {
    return d * barHeightMultiplier;
   });
    
    
    
   //Draw the text.
   dataEnter.append("text").text(function(d)
   {
    return d;
   }).attr("x", function(d, i)
   {
    return i * horizontalBarDistance + textXOffset;
   }).attr("y", textYPosition);
  });
 }
 
</script>
 
</head>
 
<body>
 
</body>
 
</html>