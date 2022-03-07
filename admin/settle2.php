<?php
/**
 * 结算操作
**/
include("../includes/common.php");
$title='结算操作';
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
		  <li class="active">
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
<?php
$count=$DB->query("SELECT * from pay_user where (money>={$conf['settle_money']} or apply=1) and account is not null and username is not null")->rowCount();
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">结算列表下载</h3></div>
        <div class="panel-body">
<?php
if(isset($_GET['creat'])){
$limit='1000';
$rs=$DB->query("SELECT * from pay_user where (money>={$conf['settle_money']} or apply=1) and account is not null and username is not null and type!=2 and active=1 limit {$limit}");

$batch=date("Ymd").rand(111,999);
$i=0;
$allmoney=0;
while($row = $rs->fetch())
{
	$i++;
	//if($row['apply']==1 && $row['money']<$conf['settle_money']){$fee=$conf['settle_fee'];$row['money']-=$fee;}
	//else $fee=0;
	$fee=round($row['money']*$conf['settle_rate'],2);
	if($fee<$conf['settle_fee_min'] || $row['money']<50)$fee=$conf['settle_fee_min'];
	if($fee>$conf['settle_fee_max'])$fee=$conf['settle_fee_max'];
	$row['money']=$row['money']-$fee;
	$DB->exec("update `pay_user` set `money`='0',`apply`='0' where `id`='{$row['id']}'");
	$DB->exec("INSERT INTO `pay_settle` (`pid`, `batch`, `type`, `username`, `account`, `money`, `fee`, `time`, `status`) VALUES ('{$row['id']}', '{$batch}', '{$row['settle_id']}', '{$row['username']}', '{$row['account']}', '{$row['money']}', '{$fee}', '{$date}', '1')");
	$allmoney+=$row['money'];
}
$DB->exec("INSERT INTO `pay_batch` (`batch`, `allmoney`, `time`, `status`) VALUES ('{$batch}', '{$allmoney}', '{$date}', '0')");
exit("<script language='javascript'>alert('生成结算列表成功！');window.location.href='./settle.php?batch={$batch}&allmoney={$allmoney}';</script>");
}elseif(isset($_GET['batch'])){
	$batch=$_GET['batch'];
	$allmoney=$_GET['allmoney'];
?>
          <form action="download.php" method="get" role="form">
		  <input type="hidden" name="batch" value="<?php echo $batch?>"/>
		  <input type="hidden" name="allmoney" value="<?php echo $allmoney?>"/>
			<p>当前需要结算的共有<?php echo $count?>条记录</p>
			<p>批次号：<?php echo $batch?></p>
            <p><input type="submit" value="下载CSV文件" class="btn btn-primary form-control"/></p>
          </form>
		  <form action="transfer.php" method="get" role="form">
		  <input type="hidden" name="batch" value="<?php echo $batch?>"/>
            <p><input type="submit" value="单笔转账到支付宝账户" class="btn btn-success form-control"/></p>
          </form>
		  <form action="wxtransfer.php" method="get" role="form">
		  <input type="hidden" name="batch" value="<?php echo $batch?>"/>
            <p><input type="submit" value="微信企业付款" class="btn btn-success form-control"/></p>
          </form>
		  <form action="qqtransfer.php" method="get" role="form">
		  <input type="hidden" name="batch" value="<?php echo $batch?>"/>
            <p><input type="submit" value="QQ钱包企业付款" class="btn btn-success form-control"/></p>
          </form>
<?php }else{?>
		  <form action="settle.php" method="get" role="form">
		  <input type="hidden" name="creat" value="1"/>
			<p>当前需要结算的共有<?php echo $count?>条记录</p>
            <p><input type="submit" value="立即生成结算列表" class="btn btn-primary form-control"/></p>
          </form>
<?php }?>
        </div>
		<div class="panel-footer">
          <span class="glyphicon glyphicon-info-sign"></span> 结算标准：金额大于<?php echo $conf['settle_money']?>元，或主动申请的（需扣除手续费<?php echo $conf['settle_fee']?>元）<br/>
		  结算列表请勿重复生成，CSV文件可以重复下载！
        </div>
      </div>
    </div>
  </div>