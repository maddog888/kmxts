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
    namespace app\index\controller;

    use think\Db;
    use think\Controller;
    use phpmailer\phpmailer;

    class Index extends Controller
    {
        public function index()
        {
        	$config = Db::table('config')->find(1);
        	$type = Db::table('type')->where('s',1)->order('or desc')->select();
        	$list = Db::query('select *,(select count(*) from kms where kms.spid = lists.id and kms.order IS NULL) AS count from lists where s = 1 ORDER BY `or` DESC');
        	$tjson = json_encode($type);
        	$ljson = json_encode($list);
            if($this->isMobile()){
                $m = 'phone';
            }else{
                $m = 'pc';
            }
        	return view($m,[
        		'config' => $config,
        		'type' => $type,
        		'list' => $list,
        		'tjson' => $tjson,
        		'ljson' => $ljson,
                'footer' => base64_decode('PGZvb3Rlcj4KCQk8aW5wdXQgdHlwZT0iaGlkZGVuIiBpZD0iQ29weXJpZ2h0IiB2YWx1ZT0ib2siPgoJCTxwPkNvcHlyaWdodCBCeSBFRExNPC9wPgoJPC9mb290ZXI+')
        	]);
        }
        public function post()
        {
            if(input('by')!='bykm.edlm.cn'){
                return $this->AjaxError('请勿修改版权部位,否则无法正常使用');
            }
            if(!empty($_POST['c'])){
                $pwd = $_POST['c'];
                //快速查询
                if(strlen($pwd)===18){
                    $s = Db::table('kms')->field('km')->where(array('order'=>$pwd))->select();
                    if($s){
                        return $this->AjaxSuccess($s);
                    }
                }
                //正式查询
                $s = Db::query('select orders.order,orders.stime,orders.type,(select title from lists where lists.id = orders.spid) AS title from orders where pwd = :pwd ORDER BY id DESC',['pwd'=>$pwd]);
                if($s){
                    return $this->AjaxSuccess($s,1);
                }
                return $this->AjaxError('查询不到关于'.$_POST['c'].'的订单数据,可稍后尝试再次查询,或联系客服');
            }
            if(!empty($_POST['id']) and !empty($_POST['time']) and !empty($_POST['type']) and !empty($_POST['pwd'])){
                $lp = Db::table('admin')->find(1);
                if(empty($lp['appid']) or empty($lp['apppwd'])){
                    return $this->AjaxError('请先联系客服配置L Pays 支付信息！');
                }
                $s = Db::table('lists')->find(function ($query){
                    $query->where('id',(int)$_POST['id']);
                });
                if(empty($s)){
                    return $this->AjaxError('商品已下架或并不存在！'); 
                }
                $c = Db::table('kms')->where('spid',$s['id'])->count();
                if((int)$_POST['time']>$c){
                    return $this->AjaxError('您太有眼光啦~一瞬间就没货啦！请联系客服补货吧~！'); 
                }
                $money = $s['money']*(int)$_POST['time'];
                $dh = $this->dh();
                $x = Db::table('orders')->insert([
                    'spid' => (int)$_POST['id'],
                    'order' => $dh,
                    'money' => $money,
                    'time' => (int)$_POST['time'],
                    'pwd' => $_POST['pwd']
                ]);
                if(!$x){
                    return $this->AjaxError('下单出错,请重试！');
                }
                //付款URL生成
                $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
                $host = $http_type.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                $host = str_replace('post', 'get', $host);
                $return = base64_encode($host.'?order='.$dh);
                $notify = base64_encode($host.'?notify=ok&order='.$dh);
                $url = 'http://pay.edlm.cn/?appid='.$lp['appid'].'&income='.$money.'&gu='.$notify.'&rurl='.$return.'&type='.$_POST['type'];
                return $this->AjaxSuccess($url);
            }
            return $this->AjaxError('未知错误,请刷新后重试！');
        }
        public function get()
        {
            if(input('by')!='bykm.edlm.cn'){
                return '请勿修改版权部位,否则无法正常使用';
            }
            if(!empty($_GET['order']) and !empty($_GET['dh']) and !empty($_GET['ltype'])){
                if(isset($_GET['notify'])){
                    $dh = $_GET['order'];
                    $wdh = $_GET['dh'];
                    $ltype = $_GET['ltype'];
                    if(strlen($dh)!=18 and strlen($wdh)!=18){
                        return redirect('/', 5, '参数错误,请勿非法操作！');
                    }
                    $s = Db::table('orders')->find(function ($query) use ($dh){
                        $query->where(array('order'=>$dh,'win_order'=>NULL));
                    });
                    if(!$s){
                        return '订单号不存在或已完成付款,请勿重新请求';
                    }
                    $w = Db::table('orders')->find(function ($query) use ($wdh){
                        $query->where(array('win_order'=>$wdh));
                    });
                    if($w){
                        return '支付订单已完成,无需再次通知';
                    }
                    //
                    $lp = Db::table('admin')->find(1);
                    if(empty($lp['appid']) or empty($lp['apppwd'])){
                        return '请先联系客服配置L Pays 支付信息！';
                    }
                    $appid = $lp['appid'];
                    $apppwd = $lp['apppwd'];
                    if($ltype==='alipay'){ 
                        $mode = "支付宝";
                        $row = $this->acs($appid,$wdh);//使用单号查询 acs是查询支付宝单号,wcs微信,qcs QQ 
                    }else if($ltype==='wxpay'){ 
                        $mode = "微信";
                        $row = $this->wcs($appid,$wdh);//使用单号查询 acs是查询支付宝单号,wcs微信,qcs QQ 
                    }else if($ltype==='qqpay'){ 
                        $mode = "QQ";
                        $row = $this->qcs($appid,$wdh);//使用单号查询 acs是查询支付宝单号,wcs微信,qcs QQ 
                    }else{
                        return '订单参数有误,请勿非法操作,此单作废';
                    }
                    $row = json_decode($row);//JSON解析 
                    //判断是否存在错误 
                    if($row->{'error'}==0){
                        $token = md5($row->{'tradeNo'}.$apppwd.$wdh);//生成此订单的唯一密钥 
                        //判断密钥是否正确 
                        if($row->{'token'}!=$token){ 
                            return 'L Pays:此数据来自外宇宙,并不是有效的数据'; 
                        } 
                        $tradeNo = $row->{'tradeNo'};//服务器返回的交易号 
                        $tradeAmount = $row->{'tradeAmount'};//金额 
                        $tradeTime = $row->{'tradeTime'};//交易时间 
                        //$goodsTitle = $row->{'goodsTitle'};//备注信息
                        //数据处理
                    }else{
                        return $row->{'msg'};
                    }
                    if($tradeAmount>=$s['money']){
                        //最后完成交易
                        $c = Db::table('kms')->where('spid',$s['spid'])->count();
                        if($s['time']>$c){
                            return '当前商品库存低于购买数量,请补足库存后补单即可'; 
                        }
                        $us = Db::table('orders')->where(array(
                            'id' => $s['id'],
                            'win_order' => NULL,
                            'type' => NULL
                        ))->update([
                            'win_order' => $wdh,
                            'type' => $ltype
                        ]);
                        if($us){
                            Db::table('kms')->where(array(
                                'spid'=>$s['spid'],
                                'order' => NULL
                            ))->limit($s['time'])->update([
                                'order' => $dh
                            ]);
                            $checkmail="/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";            
                            if(preg_match($checkmail,$s['pwd'])){
                                //发送邮件
                                Vendor('phpmailer.phpmailer');
                                $mail = new PHPMailer();
                                $cfs = Db::table('config')->find(1);
                                $ckms = Db::table('kms')->where(array('order'=>$dh))->select();
                                $kmds = '您本次购买到的卡密如下:<br>';
                                foreach ($ckms as $v) {
                                    $kmds.= $v['km'].'<br>';
                                }
                                $kmds.= '期待能与您再次交易<br>发卡网技术支持 By:EDLM';
                                $mail->IsSMTP();
                                $mail->Host = 'smtp.qq.com';
                                $mail->Port = 465;
                                $mail->SMTPAuth = true;
                                $mail->SMTPSecure = "ssl"; 
                                $mail->CharSet = "UTF-8";
                                $mail->Encoding = "base64";
                                $mail->Username = $lp['mailu'];
                                $mail->Password = $lp['mailp'];
                                $mail->Subject = '来自'.$cfs['title'].'给您发送的卡密,感谢您的信任与支持,希望与您下次交易';
                                $mail->From = $lp['mailu'];
                                $mail->FromName = $cfs['title'];
                                $mail->AddAddress($s['pwd']);
                                $mail->IsHTML(true);
                                $mail->Body = $kmds;
                                $mail->Send();
                            }
                            return '交易完成';
                        }
                        return '交易失败，请重试';
                    }else{
                        return '实付金额小于订单金额,无法完成交易,此单作废';
                    }
                    return '逻辑完成,百年一见,你都碰见,收下膝盖';
                }else{
                    return redirect('/?order='.$_GET['order'],5, '付款完毕,正在为您自动查卡！');
                }
            }
            return redirect('/', 5, '参数错误,请勿非法操作！');
        }
        //通用函数
        public function AjaxSuccess($msg,$code = 0){
            $r['code'] = $code;
            $r['msg'] = $msg;
            return $r;
        }
        public function AjaxError($msg,$code = -1){
            $r['code'] = $code;
            $r['msg'] = $msg;
            return $r;
        }
        public function dh(){
            $md5="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
            str_shuffle($md5);
            $dhs = substr(str_shuffle($md5),26,8).time();
            return $dhs;
        }
        public function getSubstr($str, $leftStr, $rightStr){
            $left = strpos($str, $leftStr);
            $right = strpos($str, $rightStr,$left);
            if($left < 0 or $right < $left) return '';
            return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
        }
        //L Pays
        public function acs($appid,$dh){
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
        public function wcs($appid,$dh){
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
        public function qcs($appid,$dh){
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
        public function isMobile(){
            if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
                return true;
            }
            if (isset($_SERVER['HTTP_VIA'])) {
                return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
            }
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile');
                if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                    return true;
                }
            }
            if (isset($_SERVER['HTTP_ACCEPT'])) {
                if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'textml') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'textml')))) {
                    return true;
                }
            }
            return false;
        }
    }
