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
        echo json_encode($temp);
        //$data = array(43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175);
        ?>
        
    </body>
</html>

<!--<html>
    <head>
        <meta charset="utf-8"><link rel="icon" href="https://jscdn.com.cn/highcharts/images/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            /* css 代码  */
        </style>
        <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
        <script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
        <script src="https://code.highcharts.com.cn/highcharts/modules/series-label.js"></script>
        <script src="https://code.highcharts.com.cn/highcharts/modules/oldie.js"></script>
        <script src="https://code.highcharts.com.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
    </head>
    <body>
        <div id="container" style="max-width:800px;height:400px"></div>
        <script>
            var table = <?php echo json_encode($temp);?>;
            var chart = Highcharts.chart('container', {
		title: {
				text: '2010 ~ 2016 年太阳能行业就业人员发展情况'
		},
		subtitle: {
				text: '数据来源：thesolarfoundation.com'
		},
		yAxis: {
				title: {
						text: '就业人数'
				}
		},
		legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle'
		},
		plotOptions: {
				series: {
						label: {
								connectorAllowed: false
						},
						pointStart: 2010
				}
		},
		series: [{
				name: '安装，实施人员',
				data: <?php echo json_encode($data);?>
		}, {
				name: '工人',
				data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
		}, {
				name: '销售',
				data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
		}, {
				name: '项目开发',
				data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227]
		}, {
				name: '其他',
				data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
		}],
		responsive: {
				rules: [{
						condition: {
								maxWidth: 500
						},
						chartOptions: {
								legend: {
										layout: 'horizontal',
										align: 'center',
										verticalAlign: 'bottom'
								}
						}
				}]
		}
});
        </script>
    </body>
</html>