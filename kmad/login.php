<?php
	require_once('alie.php');
	if(isset($_POST['login']) and $_POST['login']){
		if(isset($_POST['username']) and $_POST['username']==$auser){
			if(isset($_POST['passwords']) and md5($_POST['passwords'])==$apass){
				setcookie("edkmu",$_POST['username'],time()+3600*24);//保存账号
	            setcookie("edkmp",md5($_POST['passwords']),time()+3600*24);//保存密码
	            header('Location:index.php');
			}else{
				echo '<script type="text/javascript">alert("账号或密码错误了呢！");</script>';
			}
		}else{
			echo '<script type="text/javascript">alert("账号或密码错误了呢！");</script>';
		}
	}
?>
<!Doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>EDLM提卡系统后台管理</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="renderer" content="webkit">
	<meta http-equiv="Cache-Control" content="no-siteapp" />
	<meta name="apple-mobile-web-app-title" content="Edlm-Md"/>
	<link rel="alternate icon" type="image/png" href="../logo.png">
	<link rel="apple-touch-icon-precomposed" href="../logo.png">
	<meta name="msapplication-TileImage" content="../logo.png">
	<link rel="stylesheet" href="../css/amazeui.min.css" />
	<link rel="stylesheet" href="../css/admin.css">
	<link rel="stylesheet" href="../css/apps.css">
	<script src="../js/jquery.min.js"></script>
	<script src="../js/amazeui.min.js"></script>
</head>
<body data-type="login">
  	<div class="am-g myapp-login">
    	<div class="myapp-login-logo-block tpl-login-max">
      		<div class="myapp-login-logo-text">
        		<div class="myapp-login-logo-text">EDLM提卡系统<span> Login</span> <i class="am-icon-skyatlas"></i></div>
      		</div>
      		<div class="login-font"><span>非管理员请离开此页面</span></div>
      		<div class="am-u-sm-10 login-am-center">
        		<form class="am-form" method="post">
		            <div class="am-form-group">
		            	<p><input type="text" class="am-form-field am-round" placeholder="4~16个字符，字母/中文/数字/下划线" name="username"/></p>
		            </div>
		            <div class="am-form-group">
		            	<p><input class="am-form-field am-round" type="password" placeholder="管理员密码" name="passwords"/></p>
		            </div>
	            	<input type="submit" name="login" class="am-btn am-btn-success am-btn-block am-round" value="登录">
	        	</form>
	      	</div>
	    </div>
	</div>
	<script src="../js/llqrcode.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/analyticCode.js" type="text/javascript" charset="utf-8"></script>
	<script src="../js/kmad.js"></script>
	<script src="../js/app.js"></script>
</body>
</html>