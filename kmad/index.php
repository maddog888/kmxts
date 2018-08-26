<?php
    require_once('top.php');
    if(isset($_POST['save']) and $_POST['save']){
    	$save = $md->update('config',[
            'dhat' => $_POST['titlea'],
            'dhah' => $_POST['hrefa'],
            'dhbt' => $_POST['titleb'],
            'dhbh' => $_POST['hrefb']
        ]);
        if($save){
            echo '<script type="text/javascript">alert("保存导航信息成功");</script>';
        }else{
            echo '<script type="text/javascript">alert("保存导航信息失败,原因:你没有修改任何数据哦！");</script>';
        }
    }
    $zfbc = $md->sum('zfb','income',[
    	'AND' => [
    		'gqtime[>=]' => mktime(0,0,0,date('m'),date('d'),date('Y')),
    		'time' => '2018'
    	]
    ]);
    $zfbb = $md->count('zfb',[
    	'AND' => [
    		'gqtime[>=]' => mktime(0,0,0,date('m'),date('d'),date('Y')),
    		'time' => '2018'
    	]
    ]);
    $wxc = $md->sum('wx','income',[
    	'AND' => [
    		'gqtime[>=]' => mktime(0,0,0,date('m'),date('d'),date('Y')),
    		'time' => '2018'
    	]
    ]);
    $wxb = $md->count('wx',[
    	'AND' => [
    		'gqtime[>=]' => mktime(0,0,0,date('m'),date('d'),date('Y')),
    		'time' => '2018'
    	]
    ]);
    $qqc = $md->sum('qq','income',[
    	'AND' => [
    		'gqtime[>=]' => mktime(0,0,0,date('m'),date('d'),date('Y')),
    		'time' => '2018'
    	]
    ]);
    $qqb = $md->count('qq',[
    	'AND' => [
    		'gqtime[>=]' => mktime(0,0,0,date('m'),date('d'),date('Y')),
    		'time' => '2018'
    	]
    ]);
    $kmc = $md->count('kms',[
    	'AND' => [
    		'dh' => ''
    	]
    ]);
    $zfbz = $md->sum('zfb','income');
    $wxz = $md->sum('wx','income');
    $qqz = $md->sum('qq','income');
    $z = $zfbz+$wxz+$qqz;
    if(!$admin['dhat']){
        $md->query("ALTER TABLE `config` ADD `dhat` VARCHAR(255) NOT NULL AFTER `qq`, ADD `dhah` VARCHAR(255) NOT NULL AFTER `dhat`, ADD `dhbt` VARCHAR(255) NOT NULL AFTER `dhah`, ADD `dhbh` VARCHAR(255) NOT NULL AFTER `dhbt`");
    }
    $dh = $md->select('config',"*");
    $dh = $dh[0];
?>
		<div class="tpl-content-wrapper">
	        <div class="row">
	            <div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
	                <div class="dashboard-stat blue">
	                    <div class="visual">
	                        <i class="am-icon-paypal"></i>
	                    </div>
	                    <div class="details">
	                        <div class="number"> ￥ <?php if($zfbc){echo $zfbc;}else{echo '0';} ?> </div>
	                        <div class="desc"> 今天支付宝收入 </div>
	                    </div>
	                    <div class="more"> 支付宝今日交易笔数 <?php if($zfbb){echo $zfbb;}else{echo '0';} ?> 次 
		                    <i class="m-icon-swapright m-icon-white"></i>
		                </div>
	                </div>
	            </div>
	            <div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
	                <div class="dashboard-stat green">
	                    <div class="visual">
	                        <i class="am-icon-weixin"></i>
	                    </div>
	                    <div class="details">
	                        <div class="number"> ￥ <?php if($wxc){echo $wxc;}else{echo '0';} ?> </div>
	                        <div class="desc"> 今天微信收入 </div>
	                    </div>
	                    <div class="more"> 微信今日交易笔数 <?php if($wxb){echo $wxb;}else{echo '0';} ?> 次 
		                    <i class="m-icon-swapright m-icon-white"></i>
		                </div>
	                </div>
	            </div>
	            <div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
	                <div class="dashboard-stat red">
	                    <div class="visual">
	                        <i class="am-icon-qq"></i>
	                    </div>
	                    <div class="details">
	                        <div class="number"> ￥ <?php if($qqc){echo $qqc;}else{echo '0';} ?> </div>
	                        <div class="desc"> 今天QQ收入 </div>
	                    </div>
	                    <div class="more"> QQ今日交易笔数 <?php if($qqb){echo $qqb;}else{echo '0';} ?> 次 
		                    <i class="m-icon-swapright m-icon-white"></i>
		                </div>
	                </div>
	            </div>
	            <div class="am-u-lg-3 am-u-md-6 am-u-sm-12">
	                <div class="dashboard-stat purple">
	                    <div class="visual">
	                        <i class="am-icon-bar-chart-o"></i>
	                    </div>
	                    <div class="details">
	                        <div class="number"> <?php if($z){echo $z;}else{echo '0';} ?> 元 </div>
	                        <div class="desc"> 总交易额 </div>
	                    </div>
	                    <div class="more"> 剩余卡密  <?php if($kmc){echo $kmc;}else{echo '0';} ?> 个
		                    <i class="m-icon-swapright m-icon-white"></i>
		                </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="tpl-content-wrapper">
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 设置首页导航
                    </div>
                </div>
                <form class="am-form tpl-form-line-form" method="post">
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">导航一 <span class="tpl-form-line-small-title">标题</span></label>
                        <div class="am-u-sm-9">
                            <input type="text" class="tpl-form-input" name="titlea" placeholder="导航一的标题" value="<?php echo $dh['dhat']; ?>">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">导航一 <span class="tpl-form-line-small-title">链接</span></label>
                        <div class="am-u-sm-9">
                            <input type="text" class="tpl-form-input" name="hrefa" placeholder="导航一的链接" value="<?php echo $dh['dhah']; ?>">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">导航二 <span class="tpl-form-line-small-title">标题</span></label>
                        <div class="am-u-sm-9">
                            <input type="text" class="tpl-form-input" name="titleb" placeholder="导航二的标题" value="<?php echo $dh['dhbt']; ?>">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <label for="user-name" class="am-u-sm-3 am-form-label">导航二 <span class="tpl-form-line-small-title">链接</span></label>
                        <div class="am-u-sm-9">
                            <input type="text" class="tpl-form-input" name="hrefb" placeholder="导航二的链接" value="<?php echo $dh['dhbh']; ?>">
                        </div>
                    </div>
                    <div class="am-form-group">
                        <div class="am-u-sm-9 am-u-sm-push-3">
                            <input type="submit" value="保存" name="save" class="am-btn am-btn-primary tpl-btn-bg-color-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
<?php
	require_once('footer.php');
?>