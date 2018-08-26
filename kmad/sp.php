<?php
    require_once('top.php');
    if(isset($_POST['edit']) and $_POST['edit']){
        $edit = $md->update("lists",[
            'id' => $_POST['id'],
            'title' => $_POST['title'],
            'mode' => $_POST['mode'],
            'money' => $_POST['money'],
            'type' => $_POST['type']
        ],[
            'id' => $_POST['eid']
        ]);
        if($edit){
            echo '<script type="text/javascript">alert("修改商品信息成功");</script>';
        }else{
            echo '<script type="text/javascript">alert("修改商品信息失败,原因:你没有修改任何数据哦！");</script>';
        }
    }else if(isset($_GET['dl']) and $_GET['dl']){
        $update = $md->delete('lists',[
            'id' => clear($_GET['dl'],100)
        ]);
        if($update){
            echo '<script type="text/javascript">alert("删除此商品成功");window.location.href="sp.php";</script>';
        }else{
            echo '<script type="text/javascript">alert("删除此商品失败,请重新再试一次");window.location.href="sp.php";</script>';
        }
    }else if(isset($_POST['new']) and $_POST['new']){
        $insert = $md->insert("lists",[
            'title' => $_POST['title'],
            'mode' => $_POST['mode'],
            'money' => $_POST['money'],
            'type' => $_POST['type'],
            'spid' => md5(time().$_POST['title'])
        ]);
        if($insert){
            echo '<script type="text/javascript">alert("添加商品成功");</script>';
        }else{
            echo '<script type="text/javascript">alert("添加商品失败");</script>';
        }
    }
    if(!isset($_GET['page']) and !$_GET['page']){
        $_GET['page'] = 0;
    }
    if(isset($_GET['tid']) and $_GET['tid']){
        $typeo = $md->select('type',"*",[
            'id' => $_GET['tid']
        ]);
        $typeo = $typeo[0];
        $listss = $md->select('lists',"*",[
            'type' => clear($typeo['tid'],32),
            "LIMIT" => [clear($_GET['page'],888)*10,10]
        ]);
        $typeo = '当前:'.$typeo['name'];
        $llists = null;
        foreach ($listss as $lists) {
            $llists .= '
            <tr>
                <td>'.$lists['id'].'</td>
                <td>'.$lists['title'].'</td>
                <td>'.$lists['money'].'</td>
                <td>
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button onclick="ledit(\''.$lists['id'].'\',\''.$lists['title'].'\',\''.base64_encode($lists['mode']).'\',\''.$lists['money'].'\',\''.$lists['type'].'\')" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
                            <a href="./sp.php?dl='.$lists['id'].'" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</a>
                        </div>
                    </div>
                </td>
            </tr>';
        }
        $lc = $md->count('lists',[
            'type' => clear($typeo['tid'],32)
        ]);
    }else{
        $lc = $md->count('lists');
        $listss = $md->select('lists',"*",[
            "ORDER" => ["id" => "ASC"],
            "LIMIT" => [clear($_GET['page'],888)*10,10]
        ]);
        $typeo = "所有分类";
        $llists = null;
        foreach ($listss as $lists) {
            $llists .= '
            <tr>
                <td>'.$lists['id'].'</td>
                <td>'.$lists['title'].'</td>
                <td>'.$lists['money'].'</td>
                <td>
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button onclick="ledit(\''.$lists['id'].'\',\''.$lists['title'].'\',\''.base64_encode($lists['mode']).'\',\''.$lists['money'].'\',\''.$lists['type'].'\')" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
                            <a href="./sp.php?dl='.$lists['id'].'" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</a>
                        </div>
                    </div>
                </td>
            </tr>';
        }
    }
    $types = $md->select('type',"*",[
        "ORDER" => ["id" => "ASC"]
    ]);
    $ltype = null;
    foreach($types as $type){
        $ltype .= '<option value="'.$type['id'].'">'.$type['name'].'</option>';
        $ltypes .= '<option value="'.$type['tid'].'">'.$type['name'].'</option>';
    }
    $pages = $lc / 10;
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
?>
        <div class="tpl-content-wrapper">
            <div class="tpl-portlet-components">
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> 商品管理
                    </div>
                    <div class="am-u-sm-12 am-u-md-3">
                        <div class="am-form-group">
                            <select data-am-selected="{btnSize: 'sm',maxHeight: 150}" onchange="check(this.value);">
                                <option><?php echo $typeo; ?></option>
                                <?php
                                    echo $ltype;
                                ?>
                                </select>
                        </div>
                    </div>
                    <div class="tpl-portlet-input tpl-fz-ml">
                        <div class="portlet-input input-small input-inline">
                            <div class="input-icon right">
                                <button class="am-btn am-btn-primary am-btn-sm am-radius" onclick="newl()">添加商品</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tpl-block">
                    <div class="am-g">
                        <div class="am-u-sm-12">
                            <table class="am-table am-table-striped am-table-hover table-main">
                                <thead>
                                    <tr>
                                        <th class="table-id">ID</th>
                                        <th class="table-title">商品名称</th>
                                        <th class="table-money">商品价格</th>
                                        <th class="table-set">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        echo $llists;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="am-cf">
                        <div class="am-fr">
                            <ul class="am-pagination tpl-pagination">
                                <a class="font-green">总页数:<?php echo $pages+1; ?></a> <?php echo $last;echo $page;echo $next; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tpl-alert"></div>
            </div>
        </div>
        <!--预设-->
        <div class="am-modal am-modal-alert" tabindex="-1" id="tip">
            <div class="am-modal-dialog">
                <div class="am-modal-hd">编辑商品信息</div>
                <div id="tips" class="am-modal-bd">
                    <form class="am-form tpl-form-line-form" method="post">
                        <input type="hidden" id="eid" name="eid">
                        <div class="am-form-group">
                            <label for="doc-select-1">商品归属</label>
                            <select data-am-selected="{maxHeight: 200}" id="type" name="type">
                                <option>默认分类(不修改)</option>
                                <?php echo $ltypes; ?>
                            </select>
                            <span class="am-form-caret"></span>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">商品ID</label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="id" name="id">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">商品标题</label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="title" name="title">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">商品说明</label>
                            <div class="am-u-sm-9">
                                <textarea rows="5" id="mode" name="mode"></textarea>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">商品价格</label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="money" name="money">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <input type="submit" value="保存" name="edit" class="am-btn am-btn-secondary am-btn-block">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End 预设-->
        <!--预设-->
        <div class="am-modal am-modal-alert" tabindex="-1" id="ntip">
            <div class="am-modal-dialog">
                <div class="am-modal-hd">添加新的商品</div>
                <div id="tips" class="am-modal-bd">
                    <form class="am-form tpl-form-line-form" method="post">
                        <input type="hidden" id="eid" name="eid">
                        <div class="am-form-group">
                            <label for="doc-select-1">商品归属</label>
                            <select data-am-selected="{maxHeight: 200}" id="type" name="type">
                                <?php echo $ltypes; ?>
                            </select>
                            <span class="am-form-caret"></span>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">商品标题</label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="title" name="title">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">商品说明</label>
                            <div class="am-u-sm-9">
                                <textarea rows="5" id="mode" name="mode"></textarea>
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">商品价格</label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="money" name="money">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <input type="submit" value="添加" name="new" class="am-btn am-btn-secondary am-btn-block">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--End 预设-->
<?php
    require_once('footer.php');
?>