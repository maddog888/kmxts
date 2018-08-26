<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $html_title;?></title>
<link href="css/install.css" rel="stylesheet" type="text/css">
<link href="css/perfect-scrollbar.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="js/jquery.mousewheel.js"></script>
</head>
<body>
<?php echo $html_header;?>
<div class="main">
  <div class="text-box" id="text-box">
    <div class="license">
      <h1>系统安装协议</h1>
      <p>感谢您选择本系统。本系统是自主开发在线提卡、站长免签约零手续费，即时到账系统，于一体的网站解决方案。官方网址为 http://km.edlm.cn。</p>
      <p>本协议中，E帝联盟、EDLM，代表本公司！</p>
      <h3>协议规定的约束和限制</h3>
      <ol>
        <li>未获E帝联盟公司商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目或实现盈利的网站）。购买商业授权请登录http://km.edlm.cn参考相关说明。</li>
        <li>不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。</li>
        <li>无论用途如何、是否经过修改或美化、修改程度如何，只要使用EDLM自助提卡系统的整体或任何部分，未经授权许可，页面页脚处的EDLM自助提卡系统的版权信息都必须保留，而不能清除或修改。</li>
        <li>禁止在EDLM自助提卡系统的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</li>
        <li>如果您未能遵守本协议的条款，您的授权将被终止，所许可的权利将被收回，同时您应承担相应法律责任。</li>
      </ol>
      <p></p>
      <h3>I. 有限担保和免责声明</h3>
      <ol>
        <li>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。</li>
        <li>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。</li>
        <li>EDLM公司不对使用本软件构建的平台中的会员、商品或文章信息承担责任，全部责任由您自行承担。</li>
        <li>EDLM公司对提供的软件和服务之及时性、安全性、准确性不作担保，由于不可抗力因素、EDLM公司无法控制的因素（包括黑客攻击、停断电等）等造成软件使用和服务中止或终止，而给您造成损失的，您同意放弃追究EDLM公司责任的全部权利。</li>
        <li>EDLM公司特别提请您注意，EDLM公司为了保障公司业务发展和调整的自主权，EDLM公司拥有随时经或未经事先通知而修改服务内容、中止或终止部分或全部软件使用和服务的权利，修改会公布于EDLM公司网站相关页面上，一经公布视为通知。EDLM公司行使修改或中止、终止部分或全部软件使用和服务的权利而造成损失的，EDLM公司不需对您或任何第三方负责。</li>
      </ol>
      <p></p>
      <p>有关EDLM自助提卡系统最终用户授权协议、商业授权与技术服务的详细内容，均由EDLM公司独家提供。EDLM公司拥有在不事先通知的情况下，修改授权协议和服务价目表的权利，修改后的协议或价目表对自改变之日起的新授权用户生效。</p>
      <p>一旦您开始安EDLM系统，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权利的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权利。</p>
      <p></p>
      <p align="right">E帝联盟</p>
    </div>
  </div>
  <div class="btn-box"><a href="index.php?step=1" class="btn btn-primary">同意协议进入安装</a><a href="javascript:window.close()" class="btn">不同意</a></div>
</div>
<?php echo $html_footer;?>
<script type="text/javascript">
$(document).ready(function(){
    //自定义滚定条
    $('#text-box').perfectScrollbar();
});
</script>
</body>
</html>
