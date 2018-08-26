<?php
    require_once('top.php');
    if(isset($_POST['insert']) and $_POST['insert']){
        $sps = $md->select('lists',"*",[
            'spid' => clear($_POST['spid'],32)
        ]);
        $sp = $sps[0];
        $newkms = explode("\n",$_POST['km']);
        $y = 0;
        do{
            $newkmss = str_replace("\r", '', $newkms[$y]);
            if($newkmss){
                $insert = $md->insert("kms",[
                    'name' => clear($sp['title'],100),
                    'km' => clear($newkmss,888),
                    'spid' => clear($sp['spid'],32)
                ]);
                if(!$insert){
                    echo '<script type="text/javascript">alert("添加卡密:'.$newkmss.'失败,请稍后重新再试一次!");</script>';
                }
            }
            $y++;
        }while(count($newkms)>$y);
        if($insert){
            echo '<script type="text/javascript">alert("添加卡密完毕");</script>';
        }else{
            echo '<script type="text/javascript">alert("添加卡密失败,请稍后重新再试一次!");</script>';
        }
    }
    $listss = $md->select('lists',"*");
    $llists = null;
    foreach ($listss as $lists) {
        $llists .= '<option value="'.$lists['spid'].'">'.$lists['title'].'</option>';
    }
?>
        <div class="tpl-content-wrapper">
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 添加卡密
                    </div>
                </div>
                <div class="tpl-block">
                    <div class="am-g">
                        <div class="tpl-form-body tpl-form-line">
                            <form class="am-form tpl-form-line-form" method="post">
                                <div class="am-form-group">
                                    <label for="user-phone" class="am-u-sm-3 am-form-label">卡密归属</label>
                                    <div class="am-u-sm-9">
                                        <select data-am-selected="{maxHeight: 200}" name="spid">
                                            <?php echo $llists; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-intro" class="am-u-sm-3 am-form-label">添加卡密</label>
                                    <div class="am-u-sm-9">
                                        <textarea class="" rows="10" name="km" placeholder="一行一个卡密,允许重复"></textarea>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <div class="am-u-sm-9 am-u-sm-push-3">
                                        <input type="submit" value="添加" name="insert" class="am-btn am-btn-primary tpl-btn-bg-color-success">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    require_once('footer.php');
?>