<?php
    require_once('top.php');
    if(isset($_POST['save']) and $_POST['save']){
        $save = $md->update('gg',[
            'tta' => $_POST['tta'],
            'lla' => $_POST['lla'],
            'yya' => $_POST['yya'],
            'ttb' => $_POST['ttb'],
            'llb' => $_POST['llb'],
            'yyb' => $_POST['yyb'],
            'ttc' => $_POST['ttc'],
            'llc' => $_POST['llc'],
            'yyc' => $_POST['yyc']
        ]);
        if($save){
            echo '<script type="text/javascript">alert("保存广告信息成功");</script>';
        }else{
            echo '<script type="text/javascript">alert("保存广告信息失败,原因:你没有修改任何数据哦！");</script>';
        }
    }
    $gg = $md->select('gg',"*");
    $gg = $gg[0];
?>
        <div class="tpl-content-wrapper">
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 广告配置
                    </div>
                </div>
                <div class="tpl-block">
                    <div class="am-g">
                        <div class="tpl-form-body tpl-form-line">
                            <form class="am-form tpl-form-line-form" method="post">
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">广告A图片</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="tta" value="<?php echo $gg['tta']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">广告A链接</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="lla" value="<?php echo $gg['lla']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">广告A文字</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="yya" value="<?php echo $gg['yya']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">广告B图片</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="ttb" value="<?php echo $gg['ttb']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">广告B链接</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="llb" value="<?php echo $gg['llb']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">广告B文字</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="yyb" value="<?php echo $gg['yyb']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">广告C图片</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="ttc" value="<?php echo $gg['ttc']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">广告C链接</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="llc" value="<?php echo $gg['llc']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">广告C文字</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="yyc" value="<?php echo $gg['yyc']; ?>">
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
                </div>
            </div>
        </div>
<?php
    require_once('footer.php');
?>