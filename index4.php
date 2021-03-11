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
        ?>
        
    </body>
</html>
<!DOCTYPE HTML>
<html>
    <head>
		<style>
			#app{
				display: flex;
			}
			.side{
				width: 100px;
				background-color: #C0C0C0;
				border:2px solid #000;
				margin:200px 50px;       /*box position*/
				flex-shrink:0;
			}
			.che{
				width: 100%;
				height: 100px;
				line-height: 50px;
				font-size: 18px;
				text-align: center;
                                vertical-align: middle;
				cursor: pointer;
			}
			.content{
				margin:50px 20px;
				flex: 1;
				position: relative;
			}
			.content img{
				margin: 100px;
                                width: 50%;
			}
			.info{
				width: 200px;
				height: 40px;
				background-color: #ffb01f;
				border:2px solid #000;
				position: absolute;
			}
			.info.w{
				left: 0;
				top: 40px;
			}
			.info.s{
				right: 600px;
				top: 40px;
			}
			.info .title{
				font-size: 16px;
				font-weight: bold;
				text-align: center;
			}
		</style>
        <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
    </head>
    <body>
		<div id="app">
			<div class="side">
				<div v-for="item in che" :key="item" class="che" @click="clickItem(item)">{{item}}</div>
			</div>
			<div class="content" v-show="showChe">
				<div>{{checkedItem}}</div>
				<div class="info w" @click="clickW">
					<div class="title">Engine Temperature</div>
				</div>
				<div class="info s" @click="clickS">
					<div class="title">Engine Speed</div>
				</div>
				<img src='./picture/pupve.jpg' alt="">
			</div>
			<div class="content chart" v-show="!showChe">
				<div id="container" style="width:1000px;height:500px" v-show="clickChart==='Engine Speed'"></div>
				<div id="container2" style="width:1000px;height:500px" v-show="clickChart==='Engine Temperature'"></div>
			</div>
		</div>
        
        <script>
			var app = new Vue({
				el: '#app',
				data: {
					che:['Vehicle 1','Vehicle 2','Vehicle 3','Vehicle 4','Vehicle 5'],
					checkedItem:'Vehicle 1',
					showChe:true,
					clickChart:'Engine Speed',
					chart:null,
					chart1:null
				},
				mounted() {
					this._initChart()
					this.changeChe('Vehicle 1')
				},
				methods: {
					_initChart(){
						this.chart = Highcharts.chart('container', {
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
								data: []
							}]
						});
						this.chart1 = Highcharts.chart('container2', {
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
								data: []
							
							}]
						});
					},
					changeChe(item){
						let engspeeddata=[]
						let engtempdata=[]
						switch (item) {
							case 'Vehicle 1': 
                                                                <?php
                                                                $speed = extractSpeed($conn, 1);
                                                                $temp = extractTemp($conn, 1);
                                                                ?>
								engspeeddata=<?php echo json_encode($speed);?>;
								engtempdata=<?php echo json_encode($temp);?>;
								break;
							case 'Vehicle 2':
                                                                <?php
                                                                $speed = extractSpeed($conn, 2);
                                                                $temp = extractTemp($conn, 2);
                                                                ?>
								engspeeddata=<?php echo json_encode($speed);?>;
								engtempdata=<?php echo json_encode($temp);?>;
								break;
							case 'Vehicle 3': 
                                                                <?php
                                                                $speed = extractSpeed($conn, 3);
                                                                $temp = extractTemp($conn, 3);
                                                                ?>
								engspeeddata=<?php echo json_encode($speed);?>;
								engtempdata=<?php echo json_encode($temp);?>;
								break;
							case 'Vehicle 4': 
                                                                <?php
                                                                $speed = extractSpeed($conn, 4);
                                                                $temp = extractTemp($conn, 4);
                                                                ?>
								engspeeddata=<?php echo json_encode($speed);?>;
								engtempdata=<?php echo json_encode($temp);?>;
								break;
							case 'Vehicle 5': 
                                                                <?php
                                                                $speed = extractSpeed($conn, 5);
                                                                $temp = extractTemp($conn, 5);
                                                                ?>
								engspeeddata=<?php echo json_encode($speed);?>;
								engtempdata=<?php echo json_encode($temp);?>;
								break;
						}
						let seriesDataspeed = []
						engspeeddata.forEach(item=>{
							seriesDataspeed.push([Date.UTC(item[0], item[1]-1, item[2],item[3],item[4],item[5]), item[6] ])
						})
						let seriesDatatemp = []
						engtempdata.forEach(item=>{
							seriesDatatemp.push([Date.UTC(item[0], item[1]-1, item[2],item[3],item[4],item[5]), item[6] ])
						})
						this.chart.series[0].setData(seriesDataspeed);
                        this.chart1.series[0].setData(seriesDatatemp);
					},
					clickItem(item){
						this.showChe = true
						this.checkedItem = item
                        this.changeChe(item);
					},
					clickW(){
						this.clickChart = 'Engine Temperature'
						this.showChe = false
					},
					clickS(){
						this.clickChart = 'Engine Speed'
						this.showChe = false
					},
				},
			})
        </script>
    </body>
</html>

