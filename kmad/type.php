<?php
    require_once('top.php');
    if(isset($_POST['edit']) and $_POST['edit']){
        $edit = $md->update('type',[
            'id' => clear($_POST['id'],100),
            'name' => clear($_POST['name'],100)
        ],[
            'id' => clear($_POST['eid'],100)
        ]);
        if($edit){
            echo '<script type="text/javascript">alert("修改分类成功");</script>';
        }else{
            echo '<script type="text/javascript">alert("修改分类失败,原因:你没有修改任何数据哦！");</script>';
        }
    }else if(isset($_POST['nt']) and $_POST['nt']){
        $insert = $md->insert('type',[
            'name' => clear($_POST['nt'],100),
            'tid' => md5(time().$_POST['nt'])
        ]);
        if($insert){
            echo '<script type="text/javascript">alert("添加分类成功");</script>';
        }else{
            echo '<script type="text/javascript">alert("添加分类失败,请重新再试一次");</script>';
        }
    }else if(isset($_GET['dt']) and $_GET['dt']){
        $update = $md->delete('type',[
            'id' => clear($_GET['dt'],100)
        ]);
        if($update){
            echo '<script type="text/javascript">alert("删除此分类成功");window.location.href="type.php";</script>';
        }else{
            echo '<script type="text/javascript">alert("删除此分类失败,请重新再试一次");window.location.href="type.php";</script>';
        }
    }
    if(!isset($_GET['page']) and !$_GET['page']){
        $_GET['page'] = 0;
    }
    $types = $md->select('type',"*",[
        "ORDER" => ["id" => "ASC"],
        "LIMIT" => [clear($_GET['page'],888)*10,10]
    ]);
    $ltype = null;
    foreach ($types as $type) {
        $ltype .= '<tr>
                        <td>'.$type['id'].'</td>
                        <td>'.$type['name'].'</td>
                        <td>
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    <button onclick="tedit(\''.$type['id'].'\',\''.$type['name'].'\')" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span> 编辑</button>
                                    <a href="./type.php?dt='.$type['id'].'" class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"><span class="am-icon-trash-o"></span> 删除</a>
                                </div>
                            </div>
                        </td>
                    </tr>';
    }
    $tc = $md->count('type');
    $pages = $tc / 10;
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
                        <span class="am-icon-code"></span> 分类管理
                    </div>
                    <form method="post">
                        <div class="tpl-portlet-input tpl-fz-ml">
                            <div class="portlet-input input-small input-inline">
                                <div class="input-icon right">
                                    <input type="text" class="form-control form-control-solid" placeholder="分类名称" name="nt"></div>
                            </div>
                            <button class="am-btn am-btn-primary am-btn-xs am-radius">添加分类</button>
                        </div>
                    </form>
                </div>
                <div class="tpl-block">
                    <div class="am-g">
                        <div class="am-u-sm-12">
                            <table class="am-table am-table-striped am-table-hover table-main">
                                <thead>
                                    <tr>
                                        <th class="table-id">ID</th>
                                        <th class="table-title">分类标题</th>
                                        <th class="table-set">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        echo $ltype;
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
                <div class="am-modal-hd">修改分类</div>
                <div id="tips" class="am-modal-bd">
                    <form class="am-form tpl-form-line-form" method="post">
                        <input type="hidden" id="eid" name="eid">
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">ID</label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="id" name="id">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <label for="user-name" class="am-u-sm-3 am-form-label">分类标题</label>
                            <div class="am-u-sm-9">
                                <input type="text" class="tpl-form-input" id="name" name="name">
                            </div>
                        </div>
                        <div class="am-form-group">
                            <div class="am-u-sm-9 am-u-sm-push-3">
                                <input type="submit" value="修改" name="edit" class="am-btn am-btn-warning am-btn-block">
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