// First Chart Example - Area Line Chart
Morris.Area({
  // ID of the element in which to draw the chart.
  element: 'morris-chart-area',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
	{ d: '2012-10-01', chamados: 8 },
	{ d: '2012-10-02', chamados: 7 },
	{ d: '2012-10-03', chamados:  8 },
	{ d: '2012-10-04', chamados: 9 },
	{ d: '2012-10-05', chamados: 6 },
	{ d: '2012-10-06', chamados: 8 },
	{ d: '2012-10-07', chamados: 7 },
	{ d: '2012-10-08', chamados: 18 },
	{ d: '2012-10-09', chamados: 12 },
	{ d: '2012-10-10', chamados: 14 },
	{ d: '2012-10-11', chamados: 7 },
	{ d: '2012-10-12', chamados: 9 },
	{ d: '2012-10-13', chamados: 9 },
	{ d: '2012-10-14', chamados: 23 },
	{ d: '2012-10-15', chamados: 5 },
	{ d: '2012-10-16', chamados: 20 },
	{ d: '2012-10-17', chamados: 23 },
	{ d: '2012-10-18', chamados: 24 },
	{ d: '2012-10-19', chamados: 19 },
	{ d: '2012-10-20', chamados: 29 },
	{ d: '2012-10-21', chamados: 19 },
	{ d: '2012-10-22', chamados: 10 },
	{ d: '2012-10-23', chamados: 12 },
	{ d: '2012-10-24', chamados: 23 },
	{ d: '2012-10-25', chamados: 25 },
	{ d: '2012-10-26', chamados: 12 },
	{ d: '2012-10-27', chamados: 13 },
	{ d: '2012-10-28', chamados: 10 },
	{ d: '2012-10-29', chamados: 12 },
	{ d: '2012-10-30', chamados: 15 },
	{ d: '2012-10-31', chamados: 19 },
  ],
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
    {label: "Internet", value: 42.7},
    {label: "Outros", value: 8.3},
    {label: "Software", value: 12.8},
    {label: "Hardware", value: 36.2}
  ],
  formatter: function (y) { return y + "%" ;}
});
Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'morris-chart-line',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
	{ d: '2012-10-01', chamados: 802 },
	{ d: '2012-10-02', chamados: 783 },
	{ d: '2012-10-03', chamados:  820 },
	{ d: '2012-10-04', chamados: 839 },
	{ d: '2012-10-05', chamados: 792 },
	{ d: '2012-10-06', chamados: 859 },
	{ d: '2012-10-07', chamados: 790 },
	{ d: '2012-10-08', chamados: 1680 },
	{ d: '2012-10-09', chamados: 1592 },
	{ d: '2012-10-10', chamados: 1420 },
	{ d: '2012-10-11', chamados: 882 },
	{ d: '2012-10-12', chamados: 889 },
	{ d: '2012-10-13', chamados: 819 },
	{ d: '2012-10-14', chamados: 849 },
	{ d: '2012-10-15', chamados: 870 },
	{ d: '2012-10-16', chamados: 1063 },
	{ d: '2012-10-17', chamados: 1192 },
	{ d: '2012-10-18', chamados: 1224 },
	{ d: '2012-10-19', chamados: 1329 },
	{ d: '2012-10-20', chamados: 1329 },
	{ d: '2012-10-21', chamados: 1239 },
	{ d: '2012-10-22', chamados: 1190 },
	{ d: '2012-10-23', chamados: 1312 },
	{ d: '2012-10-24', chamados: 1293 },
	{ d: '2012-10-25', chamados: 1283 },
	{ d: '2012-10-26', chamados: 1248 },
	{ d: '2012-10-27', chamados: 1323 },
	{ d: '2012-10-28', chamados: 1390 },
	{ d: '2012-10-29', chamados: 1420 },
	{ d: '2012-10-30', chamados: 1529 },
	{ d: '2012-10-31', chamados: 1892 },
  ],
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
Morris.Bar ({
  element: 'morris-chart-bar',
  data: [
	{device: 'iPhone', geekbench: 136},
	{device: 'iPhone 3G', geekbench: 137},
	{device: 'iPhone 3GS', geekbench: 275},
	{device: 'iPhone 4', geekbench: 380},
	{device: 'iPhone 4S', geekbench: 655},
	{device: 'iPhone 5', geekbench: 1571}
  ],
  xkey: 'device',
  ykeys: ['geekbench'],
  labels: ['Geekbench'],
  barRatio: 0.4,
  xLabelAngle: 35,
  hideHover: 'auto'
});