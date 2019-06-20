<?php
	// +----------------------------------------------------------------------
	// | ThinkPHP [ WE CAN DO IT JUST THINK ]
	// +----------------------------------------------------------------------
	// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
	// +----------------------------------------------------------------------
	// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
	// +----------------------------------------------------------------------
	// | Author: liu21st <liu21st@gmail.com>
	// +----------------------------------------------------------------------
	// $Id$
	/*

    避免版权纠纷
    最早文件头部

    EDLM个人发卡网3.5
    作者：MadDog
    QQ：3283404596
    WX：Edi13146

    未经同意请勿利用本程序采取转载、出售、等宣传手段以及盈利手段！

    */
	if (is_file($_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"])) {
	    return false;
	} else {
	    if (!isset($_SERVER['PATH_INFO'])) {
	        $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'];
	    }
	    require __DIR__ . "/index.php";
	}
