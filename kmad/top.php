<?php
    error_reporting(0);
    date_default_timezone_set('PRC'); 
    require_once('alie.php');
    if(php_self()=='index.php'){
        $active = 0;
    }else if(php_self()=='c.php'){
        $active = 1;
    }else if(php_self()=='type.php'){
        $active = 2;
    }else if(php_self()=='sp.php'){
        $active = 3;
    }else if(php_self()=='newkm.php'){
        $active = 4;
    }else if(php_self()=='unsold.php'){
        $active = 5;
    }else if(php_self()=='sold.php'){
        $active = 6;
    }else if(php_self()=='admin.php'){
        $active = 7;
    }else if(php_self()=='gg.php'){
        $active = 8;
    }else{
        $active = 0;
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
    <script src="../js/base64.js"></script>
</head>
<body data-type="index">
    <header class="am-topbar am-topbar-inverse admin-header">
        <div class="am-topbar-brand">
            <p style="font-size:25px; margin-left: 10px;" href="javascript:;">后台管理</p>
        </div>
        <div class="am-icon-list tpl-header-nav-hover-ico am-fl am-margin-right">
        </div>
        <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>
        <div class="am-collapse am-topbar-collapse" id="topbar-collapse">
            <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list tpl-header-list">
                <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen" class="tpl-header-list-link"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
                <li><a href="?update" class="tpl-header-list-link"><span class="am-icon-usb"></span> 检查更新</a></li>
                <li><a href="?out" class="tpl-header-list-link"> 退出登陆 <span class="am-icon-sign-out tpl-header-list-ico-out-size"></span></a></li>
            </ul>
        </div>
    </header>
    <div class="tpl-page-container tpl-page-header-fixed">
        <div class="tpl-left-nav tpl-left-nav-hover">
            <div class="tpl-left-nav-title">
                操作列表
            </div>
            <div class="tpl-left-nav-list">
                <ul class="tpl-left-nav-menu">
                    <li class="tpl-left-nav-item">
                        <a href="index.php" class="nav-link<?php if($active==0)echo ' active'?>">
                            <i class="am-icon-home"></i>
                            <span>首页</span>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="c.php" class="nav-link<?php if($active==1)echo ' active'?>">
                            <i class="am-icon-television"></i>
                            <span>网站配置</span>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="gg.php" class="nav-link<?php if($active==8)echo ' active'?>">
                            <i class="am-icon-area-chart"></i>
                            <span>广告配置</span>
                        </a>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list<?php if($active==2 or $active==3)echo ' active'?>">
                            <i class="am-icon-wpforms"></i>
                            <span>商品管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" style="display: block;">
                            <li>
                                <a href="type.php" class="<?php if($active==2)echo 'active'?>">
                                    <i class="am-icon-angle-right"></i>
                                    <span>分类管理</span>
                                </a>
                                <a href="sp.php" class="<?php if($active==3)echo 'active'?>">
                                    <i class="am-icon-angle-right"></i>
                                    <span>商品管理</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="javascript:;" class="nav-link tpl-left-nav-link-list<?php if($active==4 or $active==5 or $active==6)echo ' active'?>">
                            <i class="am-icon-credit-card"></i>
                            <span>卡密管理</span>
                            <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right tpl-left-nav-more-ico-rotate"></i>
                        </a>
                        <ul class="tpl-left-nav-sub-menu" style="display: block;">
                            <li>
                                <a href="newkm.php" class="<?php if($active==4)echo 'active'?>">
                                    <i class="am-icon-angle-right"></i>
                                    <span>添加卡密</span>
                                </a>
                                <a href="unsold.php" class="<?php if($active==5)echo 'active'?>">
                                    <i class="am-icon-angle-right"></i>
                                    <span>已售卡密</span>
                                </a>
                                <a href="sold.php" class="<?php if($active==6)echo 'active'?>">
                                    <i class="am-icon-angle-right"></i>
                                    <span>未售卡密</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="tpl-left-nav-item">
                        <a href="admin.php" class="nav-link tpl-left-nav-link-list<?php if($active==7)echo ' active'?>">
                            <i class="am-icon-key"></i>
                            <span>管理信息</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>