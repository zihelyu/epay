<?php
include("../includes/common.php");
$title='转账到指定QQ';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">导航按钮</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./">彩虹易支付管理中心</a>
      </div><!-- /.navbar-header -->
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="./"><span class="glyphicon glyphicon-home"></span> 平台首页</a>
          </li>
		  <li><a href="./order.php"><span class="glyphicon glyphicon-shopping-cart"></span> 订单管理</a></li>
		  <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cloud"></span> 结算管理<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="./settle.php">结算操作</a></li>
			  <li><a href="./slist.php">结算记录</a><li>
            </ul>
          </li>
		  <li><a href="./ulist.php"><span class="glyphicon glyphicon-user"></span> 商户管理</a></li>
          <li><a href="./login.php?logout"><span class="glyphicon glyphicon-log-out"></span> 退出登陆</a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php

if(isset($_POST['submit'])){
	$out_biz_no = trim($_POST['out_biz_no']);
	$qq = trim($_POST['qq']);
	$memo = trim($_POST['memo']);
	$money = trim($_POST['money']);
	if (!is_numeric($qq) || strlen($qq)<6 || strlen($qq)>10) {
		showmsg('QQ号码格式错误',1);
		exit();
	}
require_once (SYSTEM_ROOT.'qqpay/qpayMchAPI.class.php');

//入参
$params = array();
$params["input_charset"] = 'UTF-8';
$params["uin"] = $qq;
$params["out_trade_no"] = $out_biz_no;
$params["fee_type"] = "CNY";
$params["total_fee"] = $money*100;
$params["memo"] = $memo; //付款备注
$params["check_name"] = 'false'; //校验用户姓名，"FORCE_CHECK"校验实名
$params["re_user_name"] = ''; //收款用户真实姓名
$params["check_real_name"] = "0"; //校验用户是否实名
$params["op_user_id"] = QpayMchConf::OP_USERID;
$params["op_user_passwd"] = md5(QpayMchConf::OP_USERPWD);
$params["spbill_create_ip"] = $clientip;

//api调用
$qpayApi = new QpayMchAPI('https://api.qpay.qq.com/cgi-bin/epay/qpay_epay_b2c.cgi', true, 10);
$ret = $qpayApi->reqQpay($params);
$result = QpayMchUtil::xmlToArray($ret);

if ($result['return_code']=='SUCCESS' && $result['result_code']=='SUCCESS') {
	$result='QQ订单号:'.$result["transaction_id"].' 交易时间:'.date('Y-m-d H:i:s',time());
}elseif(isset($result['result_code'])){
	$result='转账失败 ['.$result["err_code"].']'.$result["err_code_des"];
}else{
	$result='未知错误 '.$result["return_msg"];
}

showmsg($result,1);
exit;
}

$out_biz_no = date("YmdHis").rand(11111,99999);
?>

	  <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">转账到指定QQ</h3></div>
        <div class="panel-body">
          <form action="?" method="POST" role="form">
			<div class="form-group">
				<div class="input-group"><div class="input-group-addon">交易号</div>
				<input type="text" name="out_biz_no" value="<?php echo $out_biz_no?>" class="form-control" required/>
			</div></div>
			<div class="form-group">
				<div class="input-group"><div class="input-group-addon">收款方QQ</div>
				<input type="text" name="qq" value="" class="form-control" required/>
			</div></div>
			<div class="form-group">
				<div class="input-group"><div class="input-group-addon">转账金额</div>
				<input type="text" name="money" value="" class="form-control" placeholder="RMB/元" required/>
			</div></div>
			<div class="form-group">
				<div class="input-group"><div class="input-group-addon">转账备注</div>
				<input type="text" name="memo" value="" class="form-control" placeholder="可留空"/>
			</div></div>
            <p><input type="submit" name="submit" value="立即转账" class="btn btn-primary form-control"/></p>
          </form>
        </div>
		<div class="panel-footer">
          <span class="glyphicon glyphicon-info-sign"></span> 交易号可以防止重复转账，同一个交易号只能提交同一次转账。
        </div>
      </div>
    </div>
  </div>