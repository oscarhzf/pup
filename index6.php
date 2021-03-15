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
			.side{
				width: 100px;
				background-color: #C0C0C0;
				border:2px solid #000;
				margin:0px 50px;       /*box position*/
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
				margin:0px 20px;
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
				left: 0;
				top: 40px;
			}
			.info.s{
				left: 220px;
				top: 40px;
			}
                        .info.m{
				left: 440px;
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
				<img src='./picture/pupve.jpg' alt="">
			</div>
			<div class="content chart" v-show="!showChe">
                                <div id="map" v-show="clickChart==='Map'"></div>
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
					chart1:null,
				},
				mounted() {
                                        if(sessionStorage.login !== 'true'){
                                            window.location.href='http://localhost:89/PhpProject1/login2.php'
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
                                                <?php $date = isset($_POST['date'])? $_POST['date'] : date('Y-m-d');?>
						switch (item) {
							case 'Vehicle 1': 
                                                                <?php
                                                                extractSpeed($conn, 1, $date);
                                                                echo ";";
                                                                extractTemp($conn, 1, $date);
                                                                ?>;
								break;
							case 'Vehicle 2':
                                                                <?php
                                                                extractSpeed($conn, 2, $date);
                                                                echo ";";
                                                                extractTemp($conn, 2, $date);
                                                                ?>;
								break;
							case 'Vehicle 3': 
                                                                <?php
                                                                extractSpeed($conn, 3, $date);
                                                                echo ";";
                                                                extractTemp($conn, 3, $date);
                                                                ?>;
								break;
							case 'Vehicle 4': 
                                                                <?php
                                                                extractSpeed($conn, 4, $date);
                                                                echo ";";
                                                                extractTemp($conn, 4, $date);
                                                                ?>;
								break;
							case 'Vehicle 5': 
                                                                <?php
                                                                extractSpeed($conn, 5, $date);
                                                                echo ";";
                                                                extractTemp($conn, 5, $date);
                                                                ?>;
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
                                            }
				},
			})
        </script>
        <script>
                                function initMap() {
                                    const map = new google.maps.Map(document.getElementById("map"), {
                                      zoom: 3,
                                      center: { lat: 0, lng: -180 },
                                      mapTypeId: "terrain",
                                    });
                                    const flightPlanCoordinates = [
                                      { lat: 37.7722, lng: -122.2144 },
                                      { lat: 21.291, lng: -157.821 },
                                      { lat: -18.142, lng: 178.431 },
                                      { lat: -27.467, lng: 153.027 },
                                    ];
                                    const flightPath = new google.maps.Polyline({
                                      path: flightPlanCoordinates,
                                      geodesic: true,
                                      strokeColor: "#FF0000",
                                      strokeOpacity: 1.0,
                                      strokeWeight: 2,
                                    });
                                    flightPath.setMap(map);
                                  }
        </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDF8zxQcSyJHyurdoy4Ef02tMPw7RmvwM4&callback=initMap&libraries=&v=weekly" async></script>
    </body>
</html>

