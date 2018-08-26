<?php
	error_reporting(0);
	$ver = '3.1';
	require_once 'medoo.php';
	require_once 'config.php';
	// 初始化配置
	$md = new Medoo([
	    'database_type' => 'mysql',
	    'database_name' => $dbname,
	    'server' => $host,
	    'username' => $user,
	    'password' => $pass,
		'charset' => 'utf8',
		'port' => $port
	]);
	function getSubstr($str, $leftStr, $rightStr){
	    $left = strpos($str, $leftStr);
	    $right = strpos($str, $rightStr,$left);
	    if($left < 0 or $right < $left) return '';
	    return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
	}
	function clear($text,$time){
		if(strlen($text)>$time){
			return 'Error';
		}else{
			$url = getSubstr($text,'http','/');
			if($url==":"){
				$text = str_replace( "*", "md", $text);
				$text = str_replace("!","maddog",$text);
				$text = str_replace("(","maddog",$text);
				$text = str_replace(")","maddog",$text);
				$text = str_replace("union","你",$text);
		        $text = str_replace("SELECT","好",$text);
		        $text = str_replace("select","呀",$text);
		        $text = str_replace("from","S",$text);
		        $text = str_replace("FROM","B",$text);
				$text = str_replace("‘","m",$text);
				$text = str_replace("’","md",$text);
				$text = str_replace("'","md",$text);
				$text = str_replace("or","ormaddog",$text);
		        $text = str_replace("kms","\maddog",$text);
				return addslashes($text);
			}else if($url=="s:"){
				$text = str_replace( "*", "md", $text);
				$text = str_replace("!","maddog",$text);
				$text = str_replace("(","maddog",$text);
				$text = str_replace(")","maddog",$text);
				$text = str_replace("union","你",$text);
		        $text = str_replace("SELECT","好",$text);
		        $text = str_replace("select","呀",$text);
		        $text = str_replace("from","S",$text);
		        $text = str_replace("FROM","B",$text);
				$text = str_replace("‘","m",$text);
				$text = str_replace("’","md",$text);
				$text = str_replace("'","md",$text);
				$text = str_replace("or","ormaddog",$text);
		        $text = str_replace("kms","\maddog",$text);
				return addslashes($text);
			}
			$text = str_replace( "*", "md", $text);
			$text = str_replace( "_", "\_", $text);
			$text = str_replace( "%", "\%", $text);
			$text = str_replace("=","maddog",$text);
			$text = str_replace("!","maddog",$text);
			$text = str_replace("(","maddog",$text);
			$text = str_replace(")","maddog",$text);
			$text = str_replace("&","maddog",$text);
			$text = str_replace("?","maddog",$text);
			$text = str_replace("union","你",$text);
	        $text = str_replace("SELECT","好",$text);
	        $text = str_replace("select","呀",$text);
	        $text = str_replace("from","S",$text);
	        $text = str_replace("FROM","B",$text);
			$text = str_replace("‘","m",$text);
			$text = str_replace("’","md",$text);
			$text = str_replace("'","md",$text);
			$text = str_replace("or","ormaddog",$text);
	        $text = str_replace("kms","\maddog",$text);
			return addslashes($text);
		}
	}