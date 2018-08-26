<?php
    error_reporting(0);
    define("ROOT_PATH",str_replace("\\","/",dirname(__FILE__)));
    //判断是否已安装
    if(!is_file("./install/lock") && is_file("./install/index.php")){
        @header("location:install/index.php");
        exit;
    }
    $nwen = 0;//在此输入你想增加的交易次数，0为不增加！
    require_once('mysql.php');
    //站点信息
    $index = $md->select("config", "*");
    $index = $index[0];
    if(!$index){
        exit('Tip:连接数据库失败或数据表为空');
    }
    //广告信息
    $ggs = $md->select('gg', "*");
    $ggs = $ggs[0];
    //成功交易次数
    $now = $md->count("kms", [
        "dh[!]" => ""
    ]);
    $adminm = $md->select('admin', "*");
    $adminm = $adminm[0];
    if(!$adminm['apppwd']){
        //各收款服务状态
        $xztime = time()-60;//取现在时间减70秒
        $aqzy = $md->select('aqzy', '*');
        $aqzy = $aqzy[0];
        $oo = 0;
        if($aqzy['zfb']!='stop'){
            if($aqzy['zfb']>=$xztime){
                $zfbfk = '
                        <a onclick="pay(\'zfb\');return false" class="type_a alipay_a"></a>
                ';
            }else{$oo++;}
        }else{$oo++;}
        if($aqzy['wx']!='stop'){
            if($aqzy['wx']>=$xztime){
                $wxfk = '
                        <a onclick="pay(\'wx\');return false" class="type_a wechat_a"></a>
                ';
            }else{$oo++;}
        }else{$oo++;}
        if($aqzy['qq']!='stop'){
            if($aqzy['qq']>=$xztime){
                $qqfk = '
                        <a onclick="pay(\'qq\');return false" class="qqpay_a type_a"></a>
                ';
            }else{$oo++;}
        }else{$oo++;}
        if($oo==3){
            $fk = '
                <div class="am-panel am-panel-danger">
                    <ul class="tpl-task-list tpl-task-remind">
                        <li>
                            <center><span>Tip:站点收款服务端未挂起</span></center>
                        </li>
                    </ul>
                </div>
            ';
        }
    }else{
        $lpays = $md->select('lpays',"*",[
            'LIMIT' => [1]
        ]);
        $lpays = $lpays[0];
        if(!$lpays){
            $lpays = $md->query("
                CREATE TABLE lpays(
                id int NOT NULL AUTO_INCREMENT, 
                PRIMARY KEY(id),
                title varchar(255) NOT NULL,
                dh varchar(18) NOT NULL,
                pwd varchar(50) NOT NULL)
            ");
        }
        $fk = '<a onclick="lpays(\'zfb\');return false" class="type_a alipay_a"></a>
               <a onclick="lpays(\'wx\');return false" class="type_a wechat_a"></a>
               <a onclick="lpays(\'qq\');return false" class="qqpay_a type_a"></a>
        ';
    }
    //获取tab选项卡打开的位置
    if(isset($_GET['tab'])){
       $tabt = $_GET['tab'];
       if($tabt=='' or $tabt=='a'){
            $taba = "am-active";
        }else if($tabt=='b'){
            $tabb = "am-active";
        }else{
            $taba = "am-active";
        }
    }
?>
<!Doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $index['title']; ?> - <?php echo $index['tail']; ?></title>
<meta name="keywords" content="<?php echo $index['keywords']; ?>">
<meta name="description" content="<?php echo $index['description']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<meta name="apple-mobile-web-app-title" content="Edlm-Md"/>
<link rel="alternate icon" type="image/png" href="logo.png">
<link rel="apple-touch-icon-precomposed" href="logo.png">
<meta name="msapplication-TileImage" content="logo.png">
<link rel="stylesheet" href="css/amazeui.min.css" />
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="css/app.css">
<script src="js/jquery.min.js"></script>
<script src="js/amazeui.min.js"></script>
<script src="js/base64.js"></script>
<style type="text/css">
    html,
    body {
    	<?php if($index['background']!=""){echo 'background: url("'.$index['background'].'") no-repeat center center fixed;';}else{echo 'background: #e9ecf3;';} ?>
        overflow: inherit;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    <?php 
    	if($index['background']!=""){
    		echo '
    		.tpl-portlet {
    		    padding: 12px 20px 15px;
    		    background-color: #fff;
    		    filter:alpha(opacity:100);
    		    opacity:0.7;
    		    border-radius: 4px;
    	    }
    		';
    	}else{
    		echo '
    		.tpl-portlet {
    		    padding: 12px 20px 15px;
    		    background-color: #fff;
    		    border-radius: 4px
    		}
    		';
    	}
    ?>
</style>
</head>
<body data-type="index">
    <!--导航-->
    <header class="am-topbar am-topbar-inverse admin-header">
        <div class="am-topbar-brand">
            <a href=""><?php echo $index['title']; ?></a>
        </div>
            <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-secondary am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>
            <div class="am-collapse am-topbar-collapse" id="topbar-collapse">
                <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list tpl-header-list">
                    <?php
                        if($index['dhat']){
                            echo '<li class="tpl-header-list-link"><a target="_blank" href="'.$index['dhah'].'">'.$index['dhat'].'</a></li>';
                        }
                        if($index['dhbt']){
                            echo '<li class="tpl-header-list-link"><a target="_blank" href="'.$index['dhbh'].'">'.$index['dhbt'].'</a></li>';
                        }
                    ?>
                    <li class="tpl-header-list-link"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $index['qq']; ?>&site=qq&menu=yes">联系站长QQ:<?php echo $index['qq']; ?></a></li>
                </ul>
            </div>

    </header>
    <!--End 导航-->
    <!--身体-->
    <div class="amz-container am-cf">
        <div class="amz-banner">
            <div class="amz-container">
                <div class="am-g">
                    <br><br><br>
                    <div class="am-u-md-8 am-u-sm-centered">
                        <div class="row">
                            <div class="am-u-md-12 am-u-sm-12 row-mb">
                                <div class="tpl-portlet">
                                    <div class="tpl-portlet-title">
                                        <div class="tpl-caption font-green">
                                            <i class="am-icon-server"></i>
                                            <span> 自助操作</span>
                                        </div>
                                    </div>
                                    <div class="am-tabs tpl-index-tabs" id="doc-my-tabs" data-am-tabs="{noSwipe: 1}">
                                        <ul class="am-tabs-nav am-nav am-nav-tabs">
                                            <li class="<?php echo $taba; ?>"><a href="#tab1">购卡</a></li>
                                            <li class="<?php echo $tabb; ?>"><a href="#tab2">查卡</a></li>
                                        </ul>
                                        <!--分割线-->
                                        <div class="am-tabs-bd">
                                            <!--分割线-->
                                            <div class="am-form am-tab-panel am-fade am-in <?php echo $taba; ?>" id="tab1">
                                                <!--图片轮播-->
                                                <div class="am-form-group">
                                                    <div data-am-widget="slider" class="am-slider am-slider-c1" data-am-slider='{"directionNav":false}' >
                                                        <ul class="am-slides">
                                                            <?php
                                                            	if($ggs['yya']){
                                                            		$yy = '<div class="am-slider-desc">'.$ggs['yya'].'</div>';
                                                            	}else{
                                                            		$yy = null;
                                                            	}
                                                                echo '
                                                                    <li>
                                                                        <a href="'.$ggs['lla'].'" target="_blank"><img src="'.$ggs['tta'].'"></a>
                                                                        '.$yy.'
                                                                    </li>';
                                                                if($ggs['ttb']!=""){
                                                                	if($ggs['yyb']){
	                                                            		$yy = '<div class="am-slider-desc">'.$ggs['yyb'].'</div>';
	                                                            	}else{
	                                                            		$yy = null;
	                                                            	}
                                                                    echo '
                                                                    <li>
                                                                        <a href="'.$ggs['llb'].'" target="_blank"><img src="'.$ggs['ttb'].'"></a>
                                                                        '.$yy.'
                                                                    </li>';
                                                                }
                                                                if($ggs['ttc']!=""){
                                                                	if($ggs['yyc']){
	                                                            		$yy = '<div class="am-slider-desc">'.$ggs['yyc'].'</div>';
	                                                            	}else{
	                                                            		$yy = null;
	                                                            	}
                                                                    echo '
                                                                    <li>
                                                                        <a href="'.$ggs['llc'].'" target="_blank"><img src="'.$ggs['ttc'].'"></a>
                                                                        '.$yy.'
                                                                    </li>';
                                                                }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!--End 图片轮播-->
                                                <!--站点总交易-->
                                                <div class="dashboard-stat blue">
                                                    <div class="visual">
                                                        <i class="am-icon-skyatlas"></i>
                                                    </div>
                                                    <div class="details">
                                                        <div class="number"><?php echo $nwen + $now; ?> 次    &nbsp;&nbsp;</div>
                                                        <div class="desc"> 成功交易   &nbsp;&nbsp;</div>
                                                    </div>
                                                </div>
                                                <!--End 站点总交易-->
                                                <div class="am-form-group">
                                                    <label for="doc-select-1">商品类型 </label>
                                                    <select data-am-selected="{searchBox: 1,maxHeight: 200}" id="newtype" name="newtype" onchange="typel(this.value);">
                                                        <?php
                                                            $trows = $md->select('type', "*");
                                                            //按数据量循环转为数组并且输出
                                                            foreach($trows as $trow){
                                                                if(!isset($x))$x = null;
                                                                if(!isset($arrays))$arrays = null;
                                                                if(!isset($dous))$dous = null;
                                                                if(!isset($doudou))$doudou = null;
                                                                if(!isset($dou))$dou = null;
                                                                if(!isset($jsarray))$jsarray = null;
                                                                if(!isset($typearray))$typearray = null;
                                                                $lrows = $md->select('lists', "*", [
                                                                    'type' => $trow['tid'],
                                                                    "ORDER" => ["id" => "ASC"]
                                                                ]);
                                                                //按数据量循环转为数组并且输出
                                                                foreach($lrows as $lrow){
                                                                    $x++;
                                                                    $arrays = $arrays.$dous.'"'.$x.'":'.'"'.$lrow['title'].'"';
                                                                    $dous = ",";
                                                                }
                                                                $typearray = $typearray.$doudou.'"'.$trow['name'].'":{"time":'.$x.$dous.$arrays.'}';
                                                                $arrays = "";
                                                                $dous = "";
                                                                $x=0;
                                                                $doudou = ",";
                                                            }
                                                            $rows = $md->select('lists', "*",[
                                                                "ORDER" => ["id" => "ASC"]
                                                            ]);
                                                            //按数据量循环转为数组并且输出
                                                            foreach($rows as $row){
                                                                $n = $md->count('kms',[
                                                                    "AND" => [
                                                                        "dh" => "",
                                                                        "spid" => $row['spid']
                                                                    ]
                                                                ]);
                                                                $jsarray = $jsarray.$dou.'"'.$row['title'].'":'.json_encode(array("name"=>$row['title'],"mode"=>$row['mode'],"money"=>$row['money'],"time"=>$n,"spid"=>$row['spid']));
                                                                $dou = ',';
                                                            }
                                                            $trows = $md->select('type', "*", [
                                                                "ORDER" => ["id" => "ASC"]
                                                            ]);
                                                            //按数据量循环转为数组并且输出
                                                            foreach($trows as $trow){
                                                                echo "<option value='".$trow['name']."'>".$trow['name']."</option>
                                                                ";//输出选择框的选择项代码
                                                            }
                                                        ?>
                                                    </select>
                                                    <span class="am-form-caret"></span>
                                                </div>
                                                <div class="am-form-group">
                                                    <label for="doc-select-1">商品名称 </label>
                                                    <select data-am-selected="{searchBox: 1,maxHeight: 200}" id="newlist" name="newlist" onchange="isSelected(this.value);">
                                                        <option>请先选择商品类型</option>
                                                    </select>
                                                    <span class="am-form-caret"></span>
                                                </div>
                                                <div class="am-form-group">
                                                    <label for="doc-ds-ipt-1">商品说明</label>
                                                    <div class="am-article-bd">
                                                        <p id="mode" class="am-article-lead">此商品没有说明</p>
                                                    </div>
                                                </div>
                                                <div class="am-form-group">
                                                    <label for="doc-ds-ipt-1">商品单价 </label>
                                                    <a id="money" class="am-badge am-badge-warning am-round am-text-lg">0.00  ￥</a>
                                                </div>
                                                <div class="am-form-group">
                                                    <label for="doc-ds-ipt-1">商品余货 </label>
                                                    <a id="time" class="am-badge am-badge-success am-round am-text-lg">0  个</a>
                                                </div>
                                                <div class="am-form-group">
                                                    <label for="doc-ds-ipt-1">购买数量 </label>
                                                    <div class="am-btn-group">
                                                        <button type="button" onclick="minus()" class="am-btn am-btn-secondary am-round am-btn-xs"><span class="am-icon-minus"></span></button>
                                                        <input type="text" value="0" style="width: 50px;height:28px;" id="sl" class="am-btn am-btn-default am-round am-btn-xs" onkeyup="value=value.replace(/[^\d]/g,'')" onchange="this.value=changes(this.value)">
                                                        <button type="button" onclick="plus()" class="am-btn am-btn-secondary am-round am-btn-xs"><span class="am-icon-plus"></span></button>
                                                    </div>
                                                </div>
                                                <div class="am-form-group">
                                                    <label for="doc-ds-ipt-1">订单总计 </label>
                                                    <a id="zj" class="am-badge am-badge-danger am-round am-text-lg">0.00  ￥</a>
                                                </div>
                                                <div class="am-form-group">
                                                    <label for="doc-ds-ipt-1">查询密钥</label>
                                                    <input type="text" class="am-radius" id="pwd" name="pwd" placeholder="输入你的邮箱(可接收卡密)或一串密码" maxlength="50">
                                                </div>
                                                <div class="am-form-group">
                                                    <label for="doc-ds-ipt-1" id="model">支付方式</label>
                                                    <div class="am-form-group">
                                                        <?php
                                                            if(isset($zfbfk) and $zfbfk){
                                                                echo $zfbfk;
                                                            }
                                                            if(isset($wxfk) and $wxfk){
                                                                echo $wxfk;
                                                            }
                                                            if(isset($qqfk) and $qqfk){
                                                                echo $qqfk;
                                                            }
                                                            if(isset($fk) and $fk){
                                                                echo $fk;
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--分割线-->
                                            <div class="am-form am-tab-panel am-fade am-in <?php echo $tabb; ?>" id="tab2">
                                                <form method="post" action="?tab=b">
                                                    <div class="am-form-group">
                                                        <div class="am-input-group am-input-group-default">
                                                            <input type="hidden" name="spid" value="<?php if(isset($_GET['spid']) and $_GET['spid']){echo $_GET['spid'];} ?>">
                                                            <input type="hidden" name="pwd" value="<?php if(isset($_GET['pwd']) and $_GET['pwd']){echo $_GET['pwd'];} ?>">
                                                            <input type="hidden" name="type" value="<?php if(isset($_GET['ltype']) and $_GET['ltype']){echo $_GET['ltype'];} ?>">
                                                            <input type="text" id="text" name="text" class="am-form-field" value="<?php if(isset($_GET['dh']) and $_GET['dh']){echo $_GET['dh'];} ?>" placeholder="在此输入云端单号或联系方式或一串密码" maxlength="20">
                                                            <span class="am-input-group-btn">
                                                                <input type="submit" name="check" id="check" value="查询" class="am-btn am-btn-secondary">
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        if(isset($_POST['check']) and $_POST['check']){
                                                            include("./api.php");
                                                        }
                                                    ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End UI窗口-->
                        </div>
                        <!--底部版权-->
                        <div class="row">
                            <div class="am-u-md-12 am-u-sm-12 row-mb">
                                <div class="tpl-portlet">
                                    <center>
                                    <?php echo $index['copyright']; ?>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <!--End 底部版权-->
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>               
    <!--End 身体-->
    <!--预设提示-->
    <div class="am-modal am-modal-alert" tabindex="-1" id="tip">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">温馨提示</div>
            <div id="tips" class="am-modal-bd">
                内部错误
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn">好的，知道了</span>
            </div>
        </div>
    </div>
    <!--End 预设提示-->
    <!--公告-->
    <div class="am-modal am-modal-alert" tabindex="-1" id="gg">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">公告</div>
            <div class="am-modal-bd">
                <?php echo $index['gg']; ?>
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn">好的</span>
            </div>
        </div>
    </div>
    <!--End 公告-->
    <script type="text/javascript">
        var sj = "<?php if(isset($_GET['dh']) and $_GET['dh']){echo $_GET['dh'];} ?>";
        var gg = '<?php if(!isset($_GET['tab']) and $index['gg'])echo '1'; ?>';
        if(sj!=''){
            document.getElementById("check").click();
        }else{
            if(gg=='1'){
                var $modal = $('#gg');
                $modal.modal();
            }
        }
        var typels = {<?php echo $typearray; ?>};
        var list = {<?php echo $jsarray; ?>};
        var appid = '<?php echo $adminm['appid']; ?>';
    </script>
    <script src="js/edkm.js"></script>
    <script src="js/app.js"></script>
</body>
</html> 