<?php
    require_once('top.php');
    if(isset($_POST['save']) and $_POST['save']){
        $save = $md->update('config',[
            'title' => $_POST['title'],
            'tail' => $_POST['tail'],
            'keywords' => $_POST['keywords'],
            'description' => $_POST['description'],
            'gg' => $_POST['gg'],
            'background' => $_POST['background'],
            'qq' => $_POST['qq']
        ]);
        if($save){
            echo '<script type="text/javascript">alert("保存网站信息成功");</script>';
        }else{
            echo '<script type="text/javascript">alert("保存网站信息失败,原因:你没有修改任何数据哦！");</script>';
        }
    }
    $config = $md->select('config',"*");
    $config = $config[0];
?>
        <div class="tpl-content-wrapper">
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 网站配置
                    </div>
                </div>
                <div class="tpl-block">
                    <div class="am-g">
                        <div class="tpl-form-body tpl-form-line">
                            <form class="am-form tpl-form-line-form" method="post">
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">网站标题 <span class="tpl-form-line-small-title">Title</span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="title" placeholder="网站的名字" value="<?php echo $config['title']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">标题尾巴 <span class="tpl-form-line-small-title">Tail</span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="tail" placeholder="标题后面的小尾巴" value="<?php echo $config['tail']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label">SEO关键字 <span class="tpl-form-line-small-title">SEO</span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" placeholder="输入SEO关键字" name="keywords" value="<?php echo $config['keywords']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-intro" class="am-u-sm-3 am-form-label">网站简介</label>
                                    <div class="am-u-sm-9">
                                        <textarea class="" rows="10" name="description" placeholder="请输入搜索引擎所显示的网站简介"><?php echo $config['description']; ?></textarea>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-intro" class="am-u-sm-3 am-form-label">网站公告</label>
                                    <div class="am-u-sm-9">
                                        <textarea class="" rows="10" name="gg" placeholder="网站公告栏内容"><?php echo $config['gg']; ?></textarea>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label">背景图片 <span class="tpl-form-line-small-title">Background</span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" name="background" placeholder="留空则不使用图片作背景(图片链接地址)" value="<?php echo $config['background']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label class="am-u-sm-3 am-form-label">站长QQ <span class="tpl-form-line-small-title">QQ Number</span></label>
                                    <div class="am-u-sm-9">
                                        <input type="text" name="qq" placeholder="直接输入QQ号码即可" value="<?php echo $config['qq']; ?>">
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