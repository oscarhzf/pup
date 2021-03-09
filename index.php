<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once './database/update.php';
        require_once './database/extract.php';
        echo json_encode($temp).'<br>';
        echo json_encode($speed);
       
        ?>
        
    </body>
</html>
<!DOCTYPE HTML>
<html>
    <head>
        <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
    </head>
    <body>
        <div id="container" style="width:1000px;height:500px"></div>
        <div id="container2" style="width:1000px;height:500px"></div>
        <script>
            var engspeeddata=<?php echo json_encode($speed);?>;
            var engtempdata=<?php echo json_encode($temp);?>;
            var seriesDataspeed = []
						engspeeddata.forEach(item=>{
							seriesDataspeed.push([Date.UTC(item[0], item[1]-1, item[2],item[3],item[4],item[5]), item[6] ])
						})
            var seriesDatatemp = []
						engtempdata.forEach(item=>{
							seriesDatatemp.push([Date.UTC(item[0], item[1]-1, item[2],item[3],item[4],item[5]), item[6] ])
						})
            var chart = Highcharts.chart('container', {
	chart: {
		type: 'spline'
	},
	title: {
		text: 'PUP Vehicle Engine Speed vs.time'
	},
	subtitle: {
		text: 'Test Data'
	},
	xAxis: {
		type: 'datetime',
		title: {
			text: 'Time'
		}
	},
	colors: ['#6CF'],
	yAxis: {
		title: {
			text: 'Engine Speed (rpm)'
		},
		min: 0
	},
	tooltip: {
		headerFormat: '<b>{series.name}</b><br>',
		pointFormat: '{point.x:%e. %b}: {point.y:.f}rpm'
	},
	plotOptions: {
		spline: {
			marker: {
				enabled: true
			}
		}
	},
	series: [{
		name: 'Engine Speed vs.Time',
		data: seriesDataspeed
	}]
});
var chart1 = Highcharts.chart('container2', {
	chart: {
		type: 'spline'
	},
	title: {
		text: 'Temperature vs.time'
	},
	subtitle: {
		text: 'Test Data'
	},
	xAxis: {
		type: 'datetime',
		title: {
			text: 'Time'
		}
	},
	colors: ['#6CF'],
	yAxis: {
		title: {
			text: 'Temperature (Fahrenheit degree)'
		},
		min: 0
	},
	tooltip: {
		headerFormat: '<b>{series.name}</b><br>',
		pointFormat: '{point.x:%e. %b}: {point.y:.2f} F'
	},
	plotOptions: {
		spline: {
			marker: {
				enabled: true
			}
		}
	},
	series: [{
		name: 'Temperature vs.Time',
		data: seriesDatatemp
	
	}]
});

        </script>
    </body>
</html>