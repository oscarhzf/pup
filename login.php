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
				margin:10px 0;
			}
			.input-item span{
				font-weight: bold;
			}
			.error{color: red;font-size: 12px;text-align: left;margin-left: 89px;}
		</style>
		<script src="https://cdn.jsdelivr.net/npm/vue"></script>
    </head>
    <body>
		<div id="app">
			<div class="content">
				<div class="input-item">
					<span>用户名</span>
					<input type="text" v-model="userName" />
					<div class="error" v-show="userNameError">用户名错误</div>
				</div>
				<div class="input-item">
					<span style="letter-spacing: 8px;">密码</span>
					<input type="password" v-model="passWord" />
					<div class="error" v-show="passWordError">密码错误</div>
				</div>
				<button @click="login">登录</button>
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
							this.userNameError=trues
						}else if(this.passWord!=='123456'){
							this.userNameError=false
							this.passWordError=true
						}else{
							this.userNameError=false
							this.passWordError=false
							window.location.href='http://localhost:89/PhpProject1/index4.php'
						}
					}
				},
			})
        </script>
    </body>
</html>

