<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $html_title;?></title>
<link href="css/install.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.validation.min.js"></script>
<script type="text/javascript" src="js/jquery.icheck.min.js"></script>
<?php
if($install_error!=""){
	echo "<script language='javascript'>alert('".$install_error."');</script>";
}
?>
<script>
$(document).ready(function(){
    $('input[type="checkbox"]').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
  });
});
$(function(){
    jQuery.validator.addMethod("lettersonly", function(value, element) {
        return this.optional(element) || /^[^:%,'\*\"\s\<\>\&]+$/i.test(value);
    }, "不得含有特殊字符");
    $("#install_form").validate({
        errorElement: "font",
    rules : {
        db_host : {required : true},
        db_name : {required : true},
        db_user : {required : true},
        db_port : {required : true,digits : true},
      }
    });
    $('#next').click(function(){
        $('#install_form').submit();
    });
});
</script>
</head>
<body>
<?php echo $html_header;?>
<div class="main">
  <div class="step-box" id="step3">
    <div class="text-nav">
      <h1>Step.3</h1>
      <h2>创建数据库</h2>
      <h5>填写数据库及站点相关信息</h5>
    </div>
    <div class="procedure-nav">
      <div class="schedule-ico"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span></div>
      <div class="schedule-point-now"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span></div>
      <div class="schedule-point-bg"><span class="a"></span><span class="b"></span><span class="c"></span><span class="d"></span></div>
      <div class="schedule-line-now"><em></em></div>
      <div class="schedule-line-bg"></div>
      <div class="schedule-text"><span class="a">检查安装环境</span><span class="b">选择安装方式</span><span class="c">创建数据库</span><span class="d">安装</span></div>
    </div>
  </div>
  <form action="" id="install_form" method="post">
    <input type="hidden" value="submit" name="submitform">
    <input type="hidden" value="<?php echo $install_recover; ?>" name="install_recover">
    <div class="form-box control-group">
      <fieldset>
        <legend>数据库信息</legend>
        <div>
          <label>数据库服务器</label>
          <span>
          <input type="text" name="db_host" maxlength="50">
          </span> <em>数据库服务器地址，一般为localhost</em></div>
        <div>
          <label>数据库名</label>
          <span>
          <input type="text" name="db_name" maxlength="40">
          </span> <em></em></div>
        <div>
          <label>数据库用户名</label>
          <span>
          <input type="text" name="db_user" maxlength="38">
          </span> <em></em></div>
        <div>
          <label>数据库密码</label>
          <span>
          <input type="password" name="db_pwd" maxlength="38">
          </span> <em></em></div>
        <div>
          <label>数据库端口</label>
          <span>
          <input type="text" name="db_port" maxlength="20">
          </span> <em>数据库默认端口一般为3306</em></div>
      </fieldset>
    </div>
    <div class="btn-box"><a href="index.php?step=2" class="btn btn-primary">上一步</a><a id="next" href="javascript:void(0);" class="btn btn-primary">下一步</a></div>
  </form>
</div>
<?php echo $html_footer;?>
</body>
</html>
