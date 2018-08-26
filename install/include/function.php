<?php
/**
 * environmental check
 */
function env_check(&$env_items) {
	$env_items[] = array('name' => '操作系统', 'min' => '无限制', 'good' => 'linux', 'cur'=>PHP_OS, 'status' => 1);
	$env_items[] = array('name' => 'PHP版本', 'min' => '5.4', 'good' => '5.5', 'cur' => PHP_VERSION, 'status'=>(PHP_VERSION < 5.4 ? 0:1));
}
/**
 * file check
 */
function dirfile_check(&$dirfile_items) {
	foreach($dirfile_items as $key => $item) {
		$item_path = '/'.$item['path'];
		if($item['type'] == 'dir') {
			if(!dir_writeable(ROOT_PATH.$item_path)) {
				if(is_dir(ROOT_PATH.$item_path)) {
					$dirfile_items[$key]['status'] = 0;
					$dirfile_items[$key]['current'] = '+r';
				} else {
					$dirfile_items[$key]['status'] = -1;
					$dirfile_items[$key]['current'] = 'nodir';
				}
			} else {
				$dirfile_items[$key]['status'] = 1;
				$dirfile_items[$key]['current'] = '+r+w';
			}
		} else {
			if(file_exists(ROOT_PATH.$item_path)) {
				if(is_writable(ROOT_PATH.$item_path)) {
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '+r+w';
				} else {
					$dirfile_items[$key]['status'] = 0;
					$dirfile_items[$key]['current'] = '+r';
				}
			} else {
				if ($fp = @fopen(ROOT_PATH.$item_path,'wb+')){
					$dirfile_items[$key]['status'] = 1;
					$dirfile_items[$key]['current'] = '+r+w';
					@fclose($fp);
					@unlink(ROOT_PATH.$item_path);
				}else {
					$dirfile_items[$key]['status'] = -1;
					$dirfile_items[$key]['current'] = 'nofile';
				}
			}
		}
	}
}
/**
 * dir is writeable
 * @return number
 */
function dir_writeable($dir) {
	$writeable = 0;
	if(!is_dir($dir)) {
		@mkdir($dir, 0755);
	}else {
		@chmod($dir,0755);
	}
	if(is_dir($dir)) {
		if($fp = @fopen("$dir/test.txt", 'w')) {
			@fclose($fp);
			@unlink("$dir/test.txt");
			$writeable = 1;
		} else {
			$writeable = 0;
		}
	}
	return $writeable;
}
/**
 * function is exist
 */
function function_check(&$func_items) {
	$func = array();
	foreach($func_items as $key => $item) {
		$func_items[$key]['status'] = function_exists($item['name']) ? 1 : 0;
	}
}

function show_msg($msg){
	global $html_title,$html_header,$html_footer;
	include 'step_msg.php';
	exit();
}
//make rand
function random($length, $numeric = 0) {
	$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed[mt_rand(0, $max)];
	}
	return $hash;
}
/**
 * drop table 
 */
function droptable($table_name){
	return "DROP TABLE IF EXISTS `". $table_name ."`;";
}
