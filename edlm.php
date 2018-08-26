<?php
	function acs($appid,$dh){
		$post_data = array('dh' => $dh,'token' => md5($dh.$appid));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.edlm.cn/lps/acs/'.$appid);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		curl_close($ch);
        return $output;
	}
	function wcs($appid,$dh){
		$post_data = array('dh' => $dh,'token' => md5($dh.$appid));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.edlm.cn/lps/wcs/'.$appid);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		curl_close($ch);
        return $output;
	}
	function qcs($appid,$dh){
		$post_data = array('dh' => $dh,'token' => md5($dh.$appid));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.edlm.cn/lps/qcs/'.$appid);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		$output = curl_exec($ch);
		curl_close($ch);
        return $output;
	}