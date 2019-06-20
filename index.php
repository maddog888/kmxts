<?php
	/*

    避免版权纠纷
    最早文件头部

    EDLM个人发卡网3.5
    作者：MadDog
    QQ：3283404596
    WX：Edi13146

    未经同意请勿利用本程序采取转载、出售、等宣传手段以及盈利手段！

    */
	// [ 应用入口文件 ]

	// 定义应用目录
	define('APP_PATH', __DIR__ . '/app/');
	// 加载框架引导文件
	require __DIR__ . '/tkedlm/start.php';
    // 关闭模块的路由
    \think\App::route(false);