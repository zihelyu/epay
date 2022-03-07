<?php
/**
 * 微信登录
**/
$is_defend=true;
include("../includes/common.php");

$code_url = $siteurl.'wxlogin.php';

if($islogin2==1 && isset($_GET['unbind'])){
	$DB->exec("update `pay_user` set `wxid` =NULL where `id`='$pid'");
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功解绑微信账号！');window.location.href='./';</script>");
}elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){

$redirect_url = isset($_GET['url'])?$_GET['url']:null;
if($islogin2==1){
	exit("<script language='javascript'>window.location.href='./{$redirect_url}';</script>");
}

require_once SYSTEM_ROOT."wxpay/WxPay.Api.php";
require_once SYSTEM_ROOT."wxpay/WxPay.JsApiPay.php";

$tools = new JsApiPay();
$openId = $tools->GetOpenid();

if(!$openId)sysmsg('OpenId获取失败');

	$userrow=$DB->query("SELECT * FROM pay_user WHERE wxid='{$openId}' limit 1")->fetch();
	if($userrow){
		$pid=$userrow['id'];
		$key=$userrow['key'];
		$session=md5($pid.$key.$password_hash);
		$expiretime=time()+604800;
		$token=authcode("{$pid}\t{$session}\t{$expiretime}", 'ENCODE', SYS_KEY);
		setcookie("user_token", $token, time() + 604800);
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>window.location.href='./{$redirect_url}';</script>");
	}elseif($islogin2==1){
		$sds=$DB->exec("update `pay_user` set `wxid` ='$openId' where `id`='$pid'");
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('已成功绑定支付宝账号！');window.location.href='./';</script>");
	}else{
		$_SESSION['Oauth_wx_uid']=$openId;
		exit("<script language='javascript'>alert('请输入商户ID和密钥完成绑定');window.location.href='./login.php?connect=true';</script>");
	}
}elseif($islogin2==1){
	exit("<script language='javascript'>window.location.href='./';</script>");
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>微信登录 | <?php echo $conf['web_name']?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/bootstrap/dist/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/animate.css/animate.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/font-awesome/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/simple-line-icons/css/simple-line-icons.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/html/css/font.css" type="text/css" />
<link rel="stylesheet" href="https://template.down.swap.wang/ui/angulr_2.0.1/html/css/app.css" type="text/css" />
<style>input:-webkit-autofill{-webkit-box-shadow:0 0 0px 1000px white inset;-webkit-text-fill-color:#333;}img.logo{width:14px;height:14px;margin:0 5px 0 3px;}</style>
</head>
<body>
<div class="app app-header-fixed  ">
<div class="container w-xxl w-auto-xs" ng-controller="SigninFormController" ng-init="app.settings.container = false;">
<span class="navbar-brand block m-t" id="sitename"><?php echo $conf['web_name']?></span>
<div class="m-b-lg">
<div class="wrapper text-center">
<strong>请使用微信扫描二维码登录</strong>
</div>
<form name="form" class="form-validation">
<div class="qr-image text-center" id="qrcode">
</div>
</div>
</form>
</div>
<div class="text-center">
<p>
<small class="text-muted"><?php echo $conf['web_name']?><br>&copy; 2016~2019</small>
</p>
</div>
</div>
</div>
<script src="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/jquery/dist/jquery.min.js"></script>
<script src="https://template.down.swap.wang/ui/angulr_2.0.1/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="../assets/layer/layer.js"></script>
<script src="../assets/js/jquery-qrcode.min.js"></script>
<script>
$(document).ready(function(){
	$('#qrcode').qrcode({
        text: "<?php echo $code_url?>",
        width: 230,
        height: 230,
        foreground: "#000000",
        background: "#ffffff",
        typeNumber: -1
    });
});
</script>
</body>
</html>