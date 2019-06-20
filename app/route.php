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
	use think\Route;
	//
	Route::get('','index/index');//首页
	Route::post('post/:by$','index/post');//post
	Route::get('get/:by$','index/get');//get

	//后台
	Route::get('admin$','kmad/index/index?tz');//get
	Route::any('admin/:mod$','kmad/index/:mod');//get