<?php
    require_once('top.php');
    if(isset($_POST['save']) and $_POST['save']){
        if(isset($_POST['passwords']) and $_POST['passwords']){
            $save = $md->update('admin',[
                'username' => $_POST['username'],
                'passwords' => md5($_POST['passwords']),
                'gqtime' => $_POST['gqtime'],
                'zfbimg' => $_POST['zfb'],
                'wximg' => $_POST['wx'],
                'qqimg' => $_POST['qq'],
                'appid' => $_POST['appid'],
                'apppwd' => $_POST['apppwd'],
                'mailu' => $_POST['qqmu'],
                'mailp' => $_POST['qqmp']
            ]);
        }else{
            $save = $md->update('admin',[
                'username' => $_POST['username'],
                'gqtime' => $_POST['gqtime'],
                'zfbimg' => $_POST['zfb'],
                'wximg' => $_POST['wx'],
                'qqimg' => $_POST['qq'],
                'appid' => $_POST['appid'],
                'apppwd' => $_POST['apppwd'],
                'mailu' => $_POST['qqmu'],
                'mailp' => $_POST['qqmp']
            ]);
        }
        if($save){
            echo '<script type="text/javascript">alert("修改管理配置成功,如修改了账号或密码请手动退出重新登陆后再操作！");</script>';
        }else{
            echo '<script type="text/javascript">alert("修改管理配置失败,原因:你没有修改任何数据哦！");</script>';
        }
    }
    if(!$admin['mailu']){
        $mail = $md->query("ALTER TABLE `admin` ADD `mailu` VARCHAR(255) NOT NULL, ADD `mailp` VARCHAR(255) NOT NULL");
    }
?>
        <div class="tpl-content-wrapper">
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 管理配置
                    </div>
                </div>
                <div class="tpl-block">
                    <div class="am-g">
                        <div class="tpl-form-body tpl-form-line">
                            <form class="am-form tpl-form-line-form" method="post">
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">管理员账号</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="username" placeholder="管理员账号" value="<?php echo $admin['username']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">管理员密码</label>
                                    <div class="am-u-sm-9">
                                        <input type="password" class="tpl-form-input" name="passwords" placeholder="管理员密码">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">支付宝收款设置</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="zfb" value="<?php echo $admin['zfbimg']; ?>">
                                        <small>前往<a target="_blank" href="https://cli.im/deqr/">草料二维码解析</a>,上传支付宝收钱码贴纸上的二维码,把解析到的链接复制到这里即可</small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">微信收款设置</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="wx" value="<?php echo $admin['wximg']; ?>">
                                        <small>前往<a target="_blank" href="https://cli.im/deqr/">草料二维码解析</a>,上传微信收款二维码,把解析到的链接复制到这里即可</small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">QQ收款设置</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="qq" value="<?php echo $admin['qqimg']; ?>">
                                        <small>前往<a target="_blank" href="https://cli.im/deqr/">草料二维码解析</a>,上传QQ收款二维码,把解析到的链接复制到这里即可</small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">每个订单的有效时间/分钟</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="gqtime" value="<?php echo $admin['gqtime']; ?>">
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">QQ发件邮箱账号</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="qqmu" value="<?php echo $admin['mailu']; ?>">
                                        <small>如何开启QQ发件功能?<a target="_blank" href="https://jingyan.baidu.com/article/148a1921a8e2d34d71c3b126.html">去学习一下！</a>输入您的QQ发信账号!</small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">QQ发件邮箱密码</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="qqmp" value="<?php echo $admin['mailp']; ?>">
                                        <small>如何开启QQ发件功能?<a target="_blank" href="https://jingyan.baidu.com/article/148a1921a8e2d34d71c3b126.html">去学习一下！</a>输入您的QQ发信授权码!</small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">L Pays Id</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="appid" value="<?php echo $admin['appid']; ?>">
                                        <small>了解详细:<a href="http://lp.edlm.cn/">L Pays官网</a> !当前版本属于公测阶段,请实时关注L Pays官网QQ群了解最新消息!</small>
                                    </div>
                                </div>
                                <div class="am-form-group">
                                    <label for="user-name" class="am-u-sm-3 am-form-label">L Pays Pwd</label>
                                    <div class="am-u-sm-9">
                                        <input type="text" class="tpl-form-input" name="apppwd">
                                        <small>设置PWD之后则使用L Pays,不设置则使用默认收款</small>
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