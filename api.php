<?php
	error_reporting(0);
	@header("Content-type:text/html;charset=utf-8");
	date_default_timezone_set('PRC');
	if(isset($_POST['text']) and $_POST['text']){
        $rows = $md->select('kms', "*", [
            'dh' => clear($_POST['text'],18)
        ]);
        if($rows){
        	$kms = null;
        	foreach($rows as $row){
        		$kms .= $row['km']."\n";
            }
            $rows = $rows[0];
        	$sp = $md->select('lists', "*", [
		        'spid' => $rows['spid']
		    ]);
		    $sp = $sp[0];
            echo('
        	<div class="am-panel am-panel-default" id="look">
	            <ul class="tpl-task-list tpl-task-remind">
	                <li>
	                    <center><span>Tip:查询成功</span></center>
	                </li>
	                <li>
	                    <div class="cosA">
	                        <span class="cosIco label-info">
	                            <i class="am-icon-location-arrow"></i>
	                        </span>
	                        <span> 名称: <span class="font-green">'.$sp['title'].'</span></span>
	                    </div>
	                </li>
	                <li>
	                    <div class="cosA">
	                        <span class="cosIco">
	                            <i class="am-icon-mixcloud"></i>
	                        </span>
	                        <span> 云端单号: <span class="font-green">'.$rows['dh'].'</span></span>
	                    </div>
	                </li>
	                <li>
	                    <div class="cosA">
	                        <span class="cosIco label-danger">
	                            <i class="am-icon-key"></i>
	                        </span>
	                        <span> 卡密: <span class="font-red">(1行/1个)</span></span>
	                        <textarea rows="5">'.$kms.'</textarea>
	                    </div>
	                </li>
	                <li>
	                    <div class="cosA">
	                        <span class="cosIco label-warning">
	                            <i class="am-icon-jpy"></i>
	                        </span>
	                        <span> 价格:<span class="font-green">'.$sp['money'].'</span></span>
	                    </div>
	                </li>
	                <li>
	                    <div class="cosA">
	                        <span class="cosIco">
	                            <i class="am-icon-credit-card"></i>
	                        </span>
	                        <span> 支付方式:<span class="font-green">'.$rows['mode'].'</span></span>
	                    </div>
	                </li>
	                <li>
	                    <div class="cosA">
	                        <span class="cosIco label-warning">
	                            <i class="am-icon-history"></i>
	                        </span>
	                        <span> 提卡时间:<span class="font-green">'.date('Y-m-d H:i:s',$rows['time']).'</span></span>
	                    </div>
	                </li>
	            </ul>
	        </div>');//输出查询结果代码
	        goto out;
        	exit;
        }else{
        	if(isset($_POST['text']) and strlen($_POST['text'])==18){
		    	require_once('edlm.php');
		    	if(isset($_POST['type'])){
		    		if($_POST['type']=='alipay'){
		    			$lprow = acs($adminm['appid'],$_POST['text']);//使用单号查询 acs是查询支付宝单号,wcs微信,qcs QQ
						$lprow = json_decode($lprow);
						$mode = '支付宝';
		    		}else if($_POST['type']=='wxpay'){
		    			$lprow = wcs($adminm['appid'],$_POST['text']);//使用单号查询 acs是查询支付宝单号,wcs微信,qcs QQ
						$lprow = json_decode($lprow);
						$mode = '微信支付';
		    		}else if($_POST['type']=='qqpay'){
		    			$lprow = qcs($adminm['appid'],$_POST['text']);//使用单号查询 acs是查询支付宝单号,wcs微信,qcs QQ
						$lprow = json_decode($lprow);
						$mode = 'QQ钱包';
		    		}else{
		    			echo(tip('L Pays:参数不正确呢！'));
		    			goto out;
						exit;
		    		}
		    	}else{
		    		echo(tip('L Pays:参数不正确呢！'));
		    		goto out;
					exit;
		    	}
				if(!is_null($lprow) and $lprow->{'error'}==0){
					$token = md5($lprow->{'tradeNo'}.$adminm['apppwd'].$_POST['text']);//生成此订单的唯一密钥
					if($lprow->{'token'}!=$token){
						echo(tip('L Pays:此数据来自外宇宙,并不是有效的数据'));
			    		goto out;
						exit;
			        }else{
			        	if(isset($_POST["spid"]) and $_POST["spid"]){
			        		$sp = $md->select('lists', "*", [
				                'spid' => clear($_POST["spid"],32)
				            ]);
				            if(isset($_POST["pwd"])){
				            	$pwd = $_POST["pwd"];
				            }else{
				            	$pwd = 'maddog';
				            }
				            if($sp){
				            	$sp = $sp[0];
				            	if($lprow->{'tradeAmount'}>=$sp['money']){
				            		$lprow->{'tradeAmount'} = $lprow->{'tradeAmount'} + 0.01;//自动给收款加1分钱解决PHP除数为浮点小数的问题
				            		$moneyi = $lprow->{'tradeAmount'} / $sp['money'];
				            		$moneyi = ceil($moneyi);
								    $moneys = $lprow->{'tradeAmount'} * $moneyi;
						            if($lprow->{'tradeAmount'}<$moneys){
						              	$moneyi = $moneyi - 1;
						            }
						            $ii = null;
						            do{
						            	$count = $md->count("kms", [
						            		'dh' => clear($_POST['text'],18)
						            	]);
						            	if($count<$moneyi){
						            		$kmu = $md->select('kms', "*", [
							            		'AND' => [
							            			'dh' => '',
							            			'spid' => clear($_POST["spid"],32)
							            		],"LIMIT" => 1
							            	]);
							            	$kmu = $kmu[0];
							            	$result = $md->update('kms', [
							            		'dh' => clear($_POST['text'],18),
							            		'time' => date(time()),
							            		'mode' => $mode
							            	],[
							            		'AND' => [
							            			'dh' => '',
							            			'id' => $kmu['id'],
							            			'time' => ''
							            		]
							            	]);
						            	}
						                $ii++;
						            }while($ii<$moneyi);
						            if($result){
						            	$krows = $md->select('kms', "*", [
						            		'dh' => clear($_POST['text'],18)
						            	]);
						            	$kms = null;
						            	if($krows){
						            		foreach($krows as $krow){ 
						            			$kms .= $krow['km']."\n";
						            		}
						            		echo('
					            			<div class="am-panel am-panel-default" id="look">
							                    <ul class="tpl-task-list tpl-task-remind">
							                        <li>
							                            <center><span>Tip:提卡成功</span></center>
							                        </li>
							                        <li>
							                            <div class="cosA">
							                                <span class="cosIco label-info">
							                                    <i class="am-icon-location-arrow"></i>
							                                </span>
							                                <span> 名称: <span class="font-green">'.$sp['title'].'</span></span>
							                            </div>
							                        </li>
							                        <li>
							                            <div class="cosA">
							                                <span class="cosIco">
							                                    <i class="am-icon-mixcloud"></i>
							                                </span>
							                                <span> 云端单号: <span class="font-green">'.$_POST['text'].'</span></span>
							                            </div>
							                        </li>
							                        <li>
							                            <div class="cosA">
							                                <span class="cosIco label-danger">
							                                    <i class="am-icon-key"></i>
							                                </span>
							                                <span> 卡密: <span class="font-red">(1行/1个)</span></span>
							                  				<textarea rows="5">'.$kms.'</textarea>
							                            </div>
							                        </li>
							                        <li>
							                            <div class="cosA">
							                                <span class="cosIco label-warning">
							                                    <i class="am-icon-jpy"></i>
							                                </span>
							                                <span> 价格:<span class="font-green">'.$sp['money'].'</span></span>
							                            </div>
							                        </li>
							                        <li>
							                            <div class="cosA">
							                                <span class="cosIco">
							                                    <i class="am-icon-credit-card"></i>
							                                </span>
							                                <span> 支付方式:<span class="font-green">'.$mode.'</span></span>
							                            </div>
							                        </li>
							                        <li>
							                            <div class="cosA">
							                                <span class="cosIco label-warning">
							                                    <i class="am-icon-history"></i>
							                                </span>
							                                <span> 提卡时间:<span class="font-green">现在</span></span>
							                            </div>
							                        </li>
							                    </ul>
							                </div>
						            			');
						            		$md->insert('lpays',[
									            'title' => clear($sp['title'],255),
									            'dh' => clear($_POST['text'],18),
									            'pwd' => clear($pwd,50)
									        ]);
						            		$checkmail="/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";			
									        if(preg_match($checkmail,$pwd)){
									        	$sjr = $pwd;
		    								   	$kms = str_replace("\n","<br>",$kms);
		    								   	require_once("mail/post.php");
									        }
						            		goto out;
		        							exit;
						            	}else{
						            		echo(tip('提卡成功,但是查询的过程出现了一点小错误,请重新查询一次即可!'));
						            		goto out;
		        							exit;
						            	}
						            }else{
						            	echo(tip('提卡过程出错,请重试,或联系站长!'));
						            	goto out;
		        						exit;
						            }
				            	}else{
				            		echo(tip('实付金额于商品实价存在少付差异,因此无法提卡,请按照提示金额付款!'));
				            		goto out;
		        					exit;
				            	}
				            }else{
				            	echo(tip('没有找到该ID的商品!'));
				            	goto out;
		        				exit;
				            }
			        	}else{
			        		echo(tip('L Pays:提卡姿势不正确,请返回上一页由付款页面自动跳到此页面!'));
				    		goto out;
							exit;
			        	}
			        }
				}else{
					echo(tip($lprow->{'msg'}));
		    		goto out;
					exit;
				}
				goto out;
				exit;
        	}else{
        		$row = $md->select('zfb', "*", [
	        		'dh' => clear($_POST['text'],18)
	        	]);
	        	$mode = '支付宝';
	        	if(!$row){
	        		$row = $md->select('wx', "*", [
		        		'dh' => clear($_POST['text'],18)
		        	]);
		        	$mode = '微信支付';
		        	if(!$row){
		        		$row = $md->select('qq', "*", [
			        		'dh' => clear($_POST['text'],18)
			        	]);
			        	$mode = 'QQ钱包';
		        	}
	        	}
	        	if($row){
	        		$row = $row[0];
	        		if($row['time']=="2018"){
	        			$sp = $md->select('lists', "*", [
			                'spid' => $row['spid']
			            ]);
			            if($sp){
			            	$sp = $sp[0];
			            	if($row['income']>=$sp['money']){
			            		$row['income'] = $row['income'] + 0.01;//自动给收款加1分钱解决PHP除数为浮点小数的问题
			            		$moneyi = $row['income'] / $sp['money'];
			            		$moneyi = ceil($moneyi);
							    $moneys = $sp['money'] * $moneyi;
					            if($row['income']<$moneys){
					              	$moneyi = $moneyi - 1;
					            }
					            $ii = null;
					            do{
					            	$count = $md->count("kms", [
					            		'dh' => clear($_POST['text'],18)
					            	]);
					            	if($count<$moneyi){
					            		$kmu = $md->select('kms', "*", [
						            		'AND' => [
						            			'dh' => '',
						            			'spid' => clear($_POST["spid"],32)
						            		],"LIMIT" => 1
						            	]);
						            	$kmu = $kmu[0];
						            	$result = $md->update('kms', [
						            		'dh' => clear($_POST['text'],18),
						            		'time' => date(time()),
						            		'mode' => $mode
						            	],[
						            		'AND' => [
						            			'dh' => '',
						            			'id' => $kmu['id'],
						            			'time' => ''
						            		]
						            	]);
					            	}
					                $ii++;
					            }while($ii<$moneyi);
					            if($result){
					            	$krows = $md->select('kms', "*", [
					            		'dh' => clear($_POST['text'],18)
					            	]);
					            	$kms = null;
					            	if($krows){
					            		foreach($krows as $krow){ 
					            			$kms .= $krow['km']."\n";
					            		}
					            		echo('
				            			<div class="am-panel am-panel-default" id="look">
						                    <ul class="tpl-task-list tpl-task-remind">
						                        <li>
						                            <center><span>Tip:提卡成功</span></center>
						                        </li>
						                        <li>
						                            <div class="cosA">
						                                <span class="cosIco label-info">
						                                    <i class="am-icon-location-arrow"></i>
						                                </span>
						                                <span> 名称: <span class="font-green">'.$sp['title'].'</span></span>
						                            </div>
						                        </li>
						                        <li>
						                            <div class="cosA">
						                                <span class="cosIco">
						                                    <i class="am-icon-mixcloud"></i>
						                                </span>
						                                <span> 云端单号: <span class="font-green">'.$row['dh'].'</span></span>
						                            </div>
						                        </li>
						                        <li>
						                            <div class="cosA">
						                                <span class="cosIco label-danger">
						                                    <i class="am-icon-key"></i>
						                                </span>
						                                <span> 卡密: <span class="font-red">(1行/1个)</span></span>
						                  				<textarea rows="5">'.$kms.'</textarea>
						                            </div>
						                        </li>
						                        <li>
						                            <div class="cosA">
						                                <span class="cosIco label-warning">
						                                    <i class="am-icon-jpy"></i>
						                                </span>
						                                <span> 价格:<span class="font-green">'.$sp['money'].'</span></span>
						                            </div>
						                        </li>
						                        <li>
						                            <div class="cosA">
						                                <span class="cosIco">
						                                    <i class="am-icon-credit-card"></i>
						                                </span>
						                                <span> 支付方式:<span class="font-green">'.$mode.'</span></span>
						                            </div>
						                        </li>
						                        <li>
						                            <div class="cosA">
						                                <span class="cosIco label-warning">
						                                    <i class="am-icon-history"></i>
						                                </span>
						                                <span> 提卡时间:<span class="font-green">现在</span></span>
						                            </div>
						                        </li>
						                    </ul>
						                </div>
					            			');
					            		$checkmail="/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";			
								        if(preg_match($checkmail,$row['pwd'])){
								        	$sjr = $row['pwd'];
	    								   	$kms = str_replace("\n","<br>",$kms);
	    								   	require_once("mail/post.php");
								        }
					            		goto out;
	        							exit;
					            	}else{
					            		echo(tip('提卡成功,但是查询的过程出现了一点小错误,请重新查询一次即可!'));
					            		goto out;
	        							exit;
					            	}
					            }else{
					            	echo(tip('提卡过程出错,请重试,或联系站长!'));
					            	goto out;
	        						exit;
					            }
			            	}else{
			            		echo(tip('实付金额于商品实价存在少付差异,因此无法提卡,请按照提示金额付款!'));
			            		goto out;
	        					exit;
			            	}
			            }else{
			            	echo(tip('没有找到该ID的商品!'));
			            	goto out;
	        				exit;
			            }
	        		}else{
	        			echo(tip('您还没付款成功哦,请先付款成功后再来!'));
		            	goto out;
	        			exit;
	        		}
	        	}else{
	        		//通过联系方式查询
	        		$lpays = $md->select('lpays',"*",[
	        			'pwd' => clear($_POST['text'],50)
	        		]);
	        		if($lpays){
	        			$listsl = null;
				        foreach($lpays as $row){
			                $listsl .= '
			                <tr>
			                  <td>'.$row['title'].'</td>
			                  <td class="font-red">'.$row['dh'].'</td>
			                  <td class="font-green">付款完毕</td>
			                  <td><a href="?tab=b&dh='.$row['dh'].'" class="am-badge am-badge-success am-radius">查询此单</a></td>
			                </tr>';
				        }
	        		}else{
	        			$listsl = null;
		        		$result = $md->select('zfb', "*", [
				            'pwd' => clear($_POST['text'],50)
				        ]);
				        foreach($result as $row){
				            if($row['time']==2018){$row['time']="付款完毕";}else{$row['time']=date('Y-m-d H:i:s',$row['time']);}
			                $listsl .= '
			                <tr>
			                  <td>'.$row['title'].'</td>
			                  <td class="font-red">'.$row['dh'].'</td>
			                  <td class="font-green">'.$row['time'].'</td>
			                  <td><a href="?tab=b&dh='.$row['dh'].'" class="am-badge am-badge-success am-radius">查询此单</a></td>
			                </tr>';
				        }
				        $result = $md->select('wx', "*", [
				            'pwd' => clear($_POST['text'],50)
				        ]);
				        foreach($result as $row){
				            if($row['time']==2018){$row['time']="付款完毕";}else{$row['time']=date('Y-m-d H:i:s',$row['time']);}
			                $listsl .= '
			                <tr>
			                  <td>'.$row['title'].'</td>
			                  <td class="font-red">'.$row['dh'].'</td>
			                  <td class="font-green">'.$row['time'].'</td>
			                  <td><a href="?tab=b&dh='.$row['dh'].'" class="am-badge am-badge-success am-radius">查询此单</a></td>
			                </tr>';
				        }
				        $result = $md->select('qq', "*", [
				            'pwd' => clear($_POST['text'],50)
				        ]);
				        foreach($result as $row){
				            if($row['time']==2018){$row['time']="付款完毕";}else{$row['time']=date('Y-m-d H:i:s',$row['time']);}
			                $listsl .= '
			                <tr>
			                  <td>'.$row['title'].'</td>
			                  <td class="font-red">'.$row['dh'].'</td>
			                  <td class="font-green">'.$row['time'].'</td>
			                  <td><a href="?tab=b&dh='.$row['dh'].'" class="am-badge am-badge-success am-radius">查询此单</a></td>
			                </tr>';
				        }
	        		}
			        $listt = '
			        <div class="am-panel am-panel-default" id="looks">
			            <ul class="tpl-task-list tpl-task-remind">
			                <li>
			                    <center><span>Tip:查询成功</span></center>
			                </li>
			            </ul>
			            <div class="tpl-scrollable">
			                <table class="am-table tpl-table">
			                    <thead>
			                        <tr class="tpl-table-uppercase">
			                            <th>商品名称</th>
			                            <th>云端单号</th>
			                            <th>创建时间/状态</th>
			                            <th>操作</th>
			                        </tr>
			                    </thead>
			                    <tbody>
			                    ';
			        $listw = '
			                    </tbody>
			                </table>
			            </div>
			        </div>
			        ';
			        if($listsl==''){
			          $lists = tip('未查询到关于'.$_POST['text'].'的订单信息!');
			        }else{
			          $lists = $listt.$listsl.$listw;
			        }
			        echo $lists;
			        goto out;
	        		exit;
	        	}
	        }
        }
    }else{
    	echo(tip('云端单号为空，请输入正确的云端单号后再进行提卡操作'));
    	goto out;
        exit;
    }
	function tip($text){
	    return '
	    <div class="am-panel am-panel-default" id="look">
	        <ul class="tpl-task-list tpl-task-remind">
	            <li>
	                <center><span>Tip:'.$text.'</span></center>
	            </li>
	        </ul>
	    </div>';
	}
	out:echo '<!-- 成功跳出代码 -->';