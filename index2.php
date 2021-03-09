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
		<style>
			#app{
				display: flex;
			}
			.side{
				width: 100px;
				background-color: #fff;
				border:1px solid #000;
				margin:50px 20px;
			}
			.che{
				width: 100%;
				height: 50px;
				line-height: 50px;
				font-size: 18px;
				text-align: center;
				cursor: pointer;
			}
			.content{
				margin:50px 20px;
				flex: 1;
				position: relative;
			}
			.content img{
				margin: 100px;
			}
			.info{
				width: 200px;
				height: 150px;
				background-color: #fff;
				border:1px solid #000;
				position: absolute;
			}
			.info.w{
				left: 0;
				top: 50px;
			}
			.info.s{
				right: 0;
				top: 50px;
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
					<div class="title">温度</div>
				</div>
				<div class="info s" @click="clickS">
					<div class="title">速度</div>
				</div>
				<img src="https://th.bing.com/th/id/R1253d88b3384e47794fc1c18b5259f41?rik=t%2bPlPXGWUMld0w&riu=http%3a%2f%2fshop.xiaoche001.com%2fres%2fupload%2fproduct%2fproduct%2f20170926%2f2017IZRoTntHvi.png&ehk=SeBrAewsfkkxiDNG2guYSe%2blqB39Sf%2b0EL%2fUTXVjorg%3d&risl=&pid=ImgRaw" alt="">
			</div>
			<div class="content chart" v-show="!showChe">
				<div id="container" style="width:1000px;height:500px" v-show="clickChart==='速度'"></div>
				<div id="container2" style="width:1000px;height:500px" v-show="clickChart==='温度'"></div>
			</div>
		</div>
        
        <script>
			var app = new Vue({
				el: '#app',
				data: {
					che:['小车1','小车2','小车3','小车4','小车5'],
					checkedItem:'小车1',
					showChe:true,
					clickChart:'速度'
				},
				mounted() {
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
				},
				methods: {
					clickItem(item){
						this.showChe = true
						this.checkedItem = item
					},
					clickW(){
						this.clickChart = '温度'
						this.showChe = false
					},
					clickS(){
						this.clickChart = '速度'
						this.showChe = false
					},
				},
			})
        </script>
    </body>
</html>

