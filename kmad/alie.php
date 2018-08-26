<?php
	require_once('../mysql.php');
    $admin = $md->select("admin", "*");
    $admin = $admin[0];
    if(!$admin){
        die('Tip:连接数据库失败或数据表为空');
    }
    function php_self(){
    	return substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
    }
    if(isset($_GET['out'])){
        setcookie("edkmu","",time()+3600*24);//保存账号
        setcookie("edkmp","",time()+3600*24);//保存密码
        echo '<script type="text/javascript">alert("退出登陆成功");</script>';
        header('Location:login.php');
        exit;
    }else if(isset($_GET['update'])){
        $update = file_get_contents("http://cdn.edlm.cn/update/syb.txt");
        if(strstr($update,$ver)!=$ver){
            echo '<script type="text/javascript">alert("发现新版本,即将为你跳转到新程序下载页面");window.location.href="'.$update.'";</script>';
        }else{
            echo '<script type="text/javascript">alert("程序暂时没有更新,您的程序是最新的");</script>';
        }
    }
    $auser = $admin['username'];
    $apass = $admin['passwords'];
    if(isset($_COOKIE['edkmu']) and $_COOKIE['edkmu']==$auser){
    	if(isset($_COOKIE['edkmp']) and $_COOKIE['edkmp']==$apass){
    		if(php_self()=='login.php'){
    			header('Location:index.php');
    			exit;
    		}
	    }else{
	    	if(php_self()!='login.php'){
    			header('Location:login.php');
    			exit;
    		}
	    }
    }else{
    	if(php_self()!='login.php'){
			header('Location:login.php');
			exit;
		}
    }