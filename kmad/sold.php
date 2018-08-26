<?php
    require_once('top.php');
    if(isset($_POST['dd']) and $_POST['dd']){
        foreach($_POST['kms'] as $i){
            $dd = $md->delete('kms',[
                'id' => $i
            ]);
        }
        if($dd){
            echo '<script language="javascript">alert("删除所选卡密完毕");</script>';
        }else{
            echo '<script language="javascript">alert("删除所选卡密失败,请再试一次看看吧！");</script>';
        }
    }else if(isset($_POST['de']) and $_POST['de']){
        if(isset($_GET['spid']) and $_GET['spid']){
            $de = $md->delete('kms',[
                'AND' => [
                    'dh' => '',
                    'spid' => clear($_GET['spid'],32)
                ]
            ]);
            if($de){
                echo '<script language="javascript">alert("删除以下卡密完毕");</script>';
            }else{
                echo '<script language="javascript">alert("删除以下卡密失败,请再试一次看看吧！");</script>';
            }
        }else{
            $de = $md->delete('kms',[
                'dh' => ''
            ]);
            if($de){
                echo '<script language="javascript">alert("清空卡密完毕");</script>';
            }else{
                echo '<script language="javascript">alert("清空卡密失败,请再试一次看看吧！");</script>';
            }
        }
    }
    $listss = $md->select('lists',"*",[
        "ORDER" => ["id" => "ASC"]
    ]);
    $llists = null;
    foreach ($listss as $lists) {
        $llists .= '<option value="'.$lists['spid'].'">'.$lists['title'].'</option>';
    }
    if(isset($_GET['spid']) and $_GET['spid']){
        $pspid = '&spid='.$_GET['spid'];
        $kmc = $md->count('kms',[
            'AND' => [
                'dh' => '',
                'spid' => clear($_GET['spid'],32)
            ]
        ]);
        $kms = $md->select('kms',"*",[
            "LIMIT" => [clear($_GET['page'],888)*10,10],
            'AND' => [
                'dh' => '',
                'spid' => clear($_GET['spid'],32)
            ]
        ]);
    }else{
        $pspid = null;
        $kmc = $md->count('kms',[
            'dh' => ''
        ]);
        $kms = $md->select('kms',"*",[
            'dh' => '',
            "LIMIT" => [clear($_GET['page'],888)*10,10]
        ]);
    }
    $pages = $kmc / 10;
    $pages = floor($pages);
    $x = 0;
    $y = 1;
    $o = $pages - 1;
    while($x<=$pages){
        if(!isset($_GET['page']) or !$_GET['page']){
            $_GET['page'] = 0;
        }
        if($_GET['page']==0){
            $last = '<li class="am-disabled"><a href="#">&laquo;</a></li>';
        }else{
            $last = '<li><a href="?page=0">&laquo;</a></li>';
        }
        if($_GET['page']==$pages){
            $next = '<li class="am-disabled"><a href="#">&raquo;</a></li>';
        }else{
            $next = '<li><a href="?page='.$pages.'">&raquo;</a></li>';
        }
        if($_GET['page']==$x){
            $page .= '<li class="am-active"><a href="?page='.$x.$pspid.'">'.($x + 1).'</a></li>';
        }else{
            if($_GET['page']>=4){
                if($x==($_GET['page']-$y)){
                    $page .= '<li><a href="?page='.($x - 1).$pspid.'">'.($x).'</a></li><li><a href="?page='.($x).$pspid.'">'.($x + 1).'</a></li>';
                }
                if($x==($_GET['page']+$y)){
                    if(($_GET['page'])==$o){
                        $page .= '<li><a href="?page='.($x).$pspid.'">'.($x+1).'</a></li>';
                    }else{
                        $page .= '<li><a href="?page='.($x).$pspid.'">'.($x+1).'</a></li><li><a href="?page='.($x+1).$pspid.'">'.($x + 2).'</a></li>';
                    }
                    
                }
            }else{
                if($x<=4){
                    $page .= '<li><a href="?page='.$x.$pspid.'">'.($x + 1).'</a></li>';
                }
            }
        }
        $x++;
    }
    $kml = null;
    foreach($kms as $km){
        if($km['mode']=="支付宝"){
            $pwd = $md->select('zfb',"*",[
                'dh' => $km['dh'],
                "LIMIT" => 1
            ]);
            $pwd = $pwd[0];
        }else if($km['mode']=="微信支付"){
            $pwd = $md->select('wx',"*",[
                'dh' => $km['dh'],
                "LIMIT" => 1
            ]);
            $pwd = $pwd[0];
        }else{
            $pwd = $md->select('qq',"*",[
                'dh' => $km['dh'],
                "LIMIT" => 1
            ]);
            $pwd = $pwd[0];
        }
        $kml .= '
        <tr>
            <td><input type="checkbox" value="'.$km['id'].'" name="kms[]"></td>
            <td>'.$km['id'].'</td>
            <td>'.$km['name'].'</td>
            <td>'.$km['km'].'</td>
        </tr>
        ';
    }
?>
        <div class="tpl-content-wrapper">
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 未售卡密管理 
                    </div>
                </div>
                <form method="post">
                    <div class="tpl-block">
                        <div class="am-g">
                            <div class="am-u-sm-12">
                                <div class="am-u-sm-12 am-u-md-6">
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <button
                                                type="button"
                                                class="am-btn am-btn-default am-btn-warning"
                                                data-am-modal="{target: '#a'}">
                                                删除所选卡密
                                            </button>
                                            <button
                                                type="button"
                                                class="am-btn am-btn-default am-btn-danger"
                                                data-am-modal="{target: '#b'}">
                                                删除以下所有卡密(包括其它已分页的数据)
                                            </button>
                                            <input name="dd" id="dd" type="submit" style="display: none;">
                                            <input name="de" id="de" type="submit" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="am-u-sm-12 am-u-md-3">
                                    <div class="am-form-group">
                                        <select data-am-selected="{btnSize: 'sm',maxHeight: 200}" onchange="checkl(this.value);">
                                            <option>分类管理卡密</option>
                                            <?php
                                                echo $llists;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="am-u-sm-12 am-u-md-3">
                                    <div class="caption font-green bold">
                                        统计:当前页面共有<?php echo $kmc; ?>个卡密
                                    </div>
                                </div>
                            </div>
                                <table class="am-table am-table-striped am-table-hover table-main">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" onclick="swapCheck()" /></th> 
                                            <th class="table-id">ID</th>
                                            <th class="table-title">卡密名称</th>
                                            <th class="table-km">卡密数据</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            echo $kml;
                                        ?>
                                    </tbody>
                                </table>
                                <div class="am-cf">
                                    <div class="am-fr">
                                        <ul class="am-pagination tpl-pagination">
                                            <a class="font-green">总页数:<?php echo $pages+1; ?></a> <?php echo $last;echo $page;echo $next; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="am-modal am-modal-alert" tabindex="-1" id="a">
                <div class="am-modal-dialog">
                    <div class="am-modal-hd">数据无价,请三思</div>
                    <div class="am-modal-bd">
                        你确定要删除吗？
                    </div>
                    <div class="am-modal-footer">
                        <span class="am-modal-btn" data-am-modal-cancel>取消</span>
                        <a class="am-modal-btn" onclick="dd();" data-am-modal-confirm>确定</a>
                    </div>
                </div>
            </div>
            <div class="am-modal am-modal-alert" tabindex="-1" id="b">
                <div class="am-modal-dialog">
                    <div class="am-modal-hd">数据无价,请三思</div>
                    <div class="am-modal-bd">
                        你确定要删除吗？
                    </div>
                    <div class="am-modal-footer">
                        <span class="am-modal-btn" data-am-modal-cancel>取消</span>
                        <a class="am-modal-btn" onclick="de();" data-am-modal-confirm>确定</a>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                function dd(){
                    var dd = document.getElementById("dd");
                    dd.click();
                }
                function de(){
                    var de = document.getElementById("de");
                    de.click();
                }
            </script>
<?php
    require_once('footer.php');
?>