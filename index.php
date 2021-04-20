<!DOCTYPE HTML>
<html>
    <head>
		<style>
			#app{
				display: flex;
			}
			.noshow{
				width:0;
				height:0;
				visibility: hidden;
			}
			#map {
				height: 100%;
			}
			#map2 {
				height: 100%;
			}
			.side{
				width: 100px;
				background-color: #C0C0C0;
				border:2px solid #000;
				margin:70px 50px;       /*box position*/
				flex-shrink:0;
                                height:500px;
			}
			.che{
				width: 100%;
				height: 100px;
				line-height: 100px;
				font-size: 18px;
				text-align: center;
                                vertical-align: middle;
				cursor: pointer;
			}
			.checkedItem{
				background-color:rgba(0,0,0,0.5)
			}
			.content{
				margin:30px 20px;
				flex: 1;
				position: relative;
                                height:500px;
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
				left: 80px;
				top: 40px;
			}
			.info.s{
				left: 300px;
				top: 40px;
			}
            .info.m{
				left: 520px;
				top: 40px;             
			}
			.info.m2{
				left: 740px;
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
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    </head>
    <body>
        <form action="" method="post">
            <div>
                <label for="date">Select Date:</label>
                <input type="date" name="date" value="<?php echo isset($_POST['date'])? $_POST['date'] : date('Y-m-d');?>" max="<?php echo date('Y-m-d'); ?>"/>
                <input type="submit" name="submit" value="Submit"/>
            </div>
        </form>
	<button onclick="window.open('display.php')", type="submit">Data</button>
	<button onclick="window.open('scheduler.php')", type="submit">Scheduler</button>
        <div class="noshow">
               <?php
                require_once './database/update.php';
                require_once './database/extract.php';
                ?>
        </div>
        
		<div id="app">
			<div class="side">
				<div v-for="item in che" :key="item" class="che" :class="item===checkedItem?'checkedItem':''" @click="clickItem(item)">{{item}}</div>
			</div>
			<div class="content" v-show="showChe">
				<div>{{checkedItem}}</div>
				<div class="info w" @click="clickW">
					<div class="title">Engine Temperature</div>
				</div>
				<div class="info s" @click="clickS">
					<div class="title">Engine Speed</div>
				</div>
                <div class="info m" @click="clickM">
					<div class="title">Map</div>
				</div>
				<div class="info m2" @click="clickM2">
					<div class="title">Trajectories</div>
				</div>
				<img src='./picture/pupve.jpg' alt="">
			</div>
			<div class="content chart" v-show="!showChe">
                <div id="map" style="width:1000px;height:500px;top:40px" v-show="clickChart==='Map'"></div>
                <div id="map2" style="width:1000px;height:500px;top:40px" v-show="clickChart==='Map2'"></div>
				<div id="container" style="width:1000px;height:500px;top:60px" v-show="clickChart==='Engine Speed'"></div>
				<div id="container2" style="width:1000px;height:500px;top:60px" v-show="clickChart==='Engine Temperature'"></div>
			</div>
		</div>
        
        <script>		
			const m = {
				map:'',
				map2:''
			}
			const f = {
				flightPath:'',
				flightPath1:'',
				flightPath2:'',
				flightPath3:'',
				flightPath4:'',
				flightPath5:''
			}
			var app = new Vue({
				el: '#app',
				data: {
					che:['Vehicle 1','Vehicle 2','Vehicle 3','Vehicle 4','Vehicle 5'],
					checkedItem:'Vehicle 1',
					showChe:true,
					clickChart:'Engine Speed',
					chart:null,
					chart1:null,
				},
				mounted() {
					if(sessionStorage.login !== 'true'){
						window.location.href='login.php'
					}
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
						let gpsdata=[]
						<?php $date = isset($_POST['date'])? $_POST['date'] : date('Y-m-d');?>
						switch (item) {
							case 'Vehicle 1': 
								<?php
								extractSpeed($conn, 1, $date);
								echo ";";
								extractTemp($conn, 1, $date);
								?>;
								removeline()
								clearMarkers()
								addline(1,m.map,'')
								break;
							case 'Vehicle 2':
								<?php
								extractSpeed($conn, 2, $date);
								echo ";";
								extractTemp($conn, 2, $date);
								?>;
								removeline()
								clearMarkers()
								addline(2,m.map,'')
								break;
							case 'Vehicle 3': 
								<?php
								extractSpeed($conn, 3, $date);
								echo ";";
								extractTemp($conn, 3, $date);
								?>;
								removeline()
								clearMarkers()
								addline(3,m.map,'')
								break;
							case 'Vehicle 4': 
								<?php
								extractSpeed($conn, 4, $date);
								echo ";";
								extractTemp($conn, 4, $date);
								?>;
								removeline()
								clearMarkers()
								addline(4,m.map,'')
								break;
							case 'Vehicle 5': 
								<?php
								extractSpeed($conn, 5, $date);
								echo ";";
								extractTemp($conn, 5, $date);
								?>;
								removeline()
								clearMarkers()
								addline(5,m.map,'')
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
                    clickM(){
                        this.clickChart = 'Map'
						this.showChe = false
                    },
					clickM2(){
                        this.clickChart = 'Map2'
						this.showChe = false
                    }
				},
			})
			let markers = [];
			let markers2 = [];
			function initMap() {
				m.map = new google.maps.Map(document.getElementById("map"), {
					zoom: 12,
					center: { lat: 40.416, lng: -86.919 },
					mapTypeId: "terrain",
				});
				addline(1,m.map,'')
				m.map2 = new google.maps.Map(document.getElementById("map2"), {
					zoom: 12,
					center: { lat: 40.416, lng: -86.919 },
					mapTypeId: "terrain",
				});
				addline(1,m.map2,1)
				addline(2,m.map2,2)
				addline(3,m.map2,3)
				addline(4,m.map2,4)
				addline(5,m.map2,5)
			}
			
			function addline(num,map,n){
				let gps=[]
				switch (num) {
					case 1: 
						<?php
						extractGPS($conn, 1, $date);
						?>;
						break;
					case 2:
						<?php
						extractGPS($conn, 2, $date);
						?>;
						break;
					case 3: 
						<?php
						extractGPS($conn, 3, $date);
						?>;
						break;
					case 4: 
						<?php
						extractGPS($conn, 4, $date);
						?>;
						break;
					case 5: 
						<?php
						extractGPS($conn, 5, $date);
						?>;
						break;
				}
				let flightPlanCoordinates = []
				gps.forEach(item=>{
					flightPlanCoordinates.push({ lat: item[6], lng: item[7] })
				})
				let center = new google.maps.LatLng(flightPlanCoordinates[0].lat,flightPlanCoordinates[0].lng);
            	map.panTo(center);
				arr = ['#FF0000','#f47920','#b2d235','#2a5caa','#6f60aa']
				f['flightPath'+n] = new google.maps.Polyline({
					path: flightPlanCoordinates,
					geodesic: true,
					strokeColor: arr[num],
					strokeOpacity: 1.0,
					strokeWeight: 2,
				});
				f['flightPath'+n].setMap(map);
				addMarker(flightPlanCoordinates[0], map, 'Start');
				addMarker(flightPlanCoordinates[flightPlanCoordinates.length-1], map, 'End');
			}

			function removeline(){
				f.flightPath.setMap(null);
			}

			function addMarker(location, map, label) {
				const marker = new google.maps.Marker({
					position: location,
					label: label,
					map: map,
				});
				markers.push(marker);
			}
			// Sets the map on all markers in the array.
			function setMapOnAll(map) {
				for (let i = 0; i < markers.length; i++) {
					markers[i].setMap(map);
				}
			}
			// Removes the markers from the map, but keeps them in the array.
			function clearMarkers() {
				setMapOnAll(null);
			}
        </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDF8zxQcSyJHyurdoy4Ef02tMPw7RmvwM4&callback=initMap&libraries=&v=weekly" async></script>
    </body>
</html>

