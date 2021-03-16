<!DOCTYPE HTML>
<html>
    <head>
		<style>
			html,body,#app{
				width:100%;
				height:100%;
				margin: 0;
				padding: 0;
			}
			.content{
				width: 300px;
				height: 300px;
				position: absolute;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				margin: auto;
				text-align: center;
			}
			.input-item{
				margin:20px 0;
			}
			.input-item span{
				font-weight: bold;
			}
			.error{color: red;font-size: 12px;text-align: left;margin-left: 10px;}
		</style>
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
    </head>
    <body>
		<div id="app">
			<div class="content">
				<div class="input-item">
					<span>User Name</span>
					<input type="text" v-model="userName" />
					<div class="error" v-show="userNameError">User name uncorrected</div>
				</div>
				<div class="input-item">
					<span style="letter-spacing: 1px;">Password</span>
					<input type="password" v-model="passWord" />
					<div class="error" v-show="passWordError">Password uncorrected</div>
				</div>
				<button @click="login">Login</button>
			</div>
		</div>
        <script>
			var app = new Vue({
				el: '#app',
				data: {
					userName:'',
					passWord:'',
					userNameError:false,
					passWordError:false,
				},
				mounted() {
					
				},
				methods: {
					login(){
						if(this.userName!=='admin'){
							this.userNameError=true
						}else if(this.passWord!=='123456'){
							this.userNameError=false
							this.passWordError=true
						}else{
							this.userNameError=false
							this.passWordError=false
                                                        sessionStorage.login = 'true'
							window.location.href='index6.php'
						}
					}
				},
			})
        </script>
    </body>
</html>

