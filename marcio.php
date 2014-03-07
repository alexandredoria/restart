<html>
<head>
<link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>

</head>
<body>
<div id="morris-chart-area" style="height: 250px;"></div>
<div id="morris-chart-donut" style="height: 250px;"></div>
<div id="morris-chart-line" style="height: 250px;"></div>
<div id="morris-chart-bar" style="height: 250px;"></div>

<?php
$data1 = array ("2011"=>3,"2014"=>5);
$data2 = array ("Hardware"=>3,"Software"=>2, "Outros"=>5,"de pensar"=>85);
?>
<script>// First Chart Example - Area Line Chart

Morris.Area({
  // ID of the element in which to draw the chart.
  element: 'morris-chart-area',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
  	<?php
	foreach ($data1 as $key=>$value) {
		echo "{ d: '".$key."', chamados: ".$value." },";
	}
	?>

	{ d: '2014', Chamadosos: 1 }  ],
  // The name of the data record attribute that contains x-chamadoss.
  xkey: 'd',
  // A list of names of data record attributes that contain y-chamadoss.
  ykeys: ['chamados'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Chamados'],
  // Disables line smoothing
  smooth: false,
});

Morris.Donut({
  element: 'morris-chart-donut',
  data: [
  	<?php
	foreach ($data2 as $key=>$value) {
		echo "{ label: '".$key."', value: ".$value." },";
	}
	?>
    {label: "saporra", value: 5}
  ],
  formatter: function (y) { return y + "%" ;}
});

</script>
</body>
</html>