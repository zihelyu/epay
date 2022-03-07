<?php
$is_defend=true;
require './includes/common.php';
@header('Content-Type: text/html; charset=UTF-8');

$trade_no=daddslashes($_GET['trade_no']);
$sitename=base64_decode(daddslashes($_GET['sitename']));
$row=$DB->query("SELECT * FROM pay_order WHERE trade_no='{$trade_no}' limit 1")->fetch();
if(!$row)sysmsg('该订单号不存在，请返回来源地重新发起请求！');

if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false){
	include('wxopen.php');
	exit;
}

require_once(SYSTEM_ROOT."f2fpay/model/builder/AlipayTradePrecreateContentBuilder.php");
require_once(SYSTEM_ROOT."f2fpay/AlipayTradeService.php");

$name = 'onlinepay-'.time();
// 创建请求builder，设置请求参数
$qrPayRequestBuilder = new AlipayTradePrecreateContentBuilder();
$qrPayRequestBuilder->setOutTradeNo($trade_no);
$qrPayRequestBuilder->setTotalAmount($row['money']);
$qrPayRequestBuilder->setSubject($name);

// 调用qrPay方法获取当面付应答
$qrPay = new AlipayTradeService($config);
$qrPayResult = $qrPay->qrPay($qrPayRequestBuilder);

//	根据状态值进行业务处理
$status = $qrPayResult->getTradeStatus();
$response = $qrPayResult->getResponse();
if($status == 'SUCCESS'){
	$code_url = $response->qr_code;
}elseif($status == 'FAILED'){
	sysmsg('支付宝创建订单二维码失败！['.$response->sub_code.']'.$response->sub_msg);
}else{
	print_r($response);
	sysmsg('系统异常，状态未知！');
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="zh-cn">
<meta name="renderer" content="webkit">
<title>支付宝扫码支付 - <?php echo $sitename?></title>
<link href="assets/css/alipay_pay.css" rel="stylesheet" media="screen">
</head>
<body>
<div class="body">
<h1 class="mod-title">
<span class="ico-wechat"></span><span class="text">支付宝扫码支付</span>
</h1>
<div class="mod-ct">
<div class="order">
</div>
<div class="amount">￥<?php echo $row['money']?></div>
<div class="qr-image" id="qrcode">
</div>
 
<div class="detail" id="orderDetail">
<dl class="detail-ct" style="display: none;">
<dt>购买物品</dt>
<dd id="productName"><?php echo $row['name']?></dd>
<dt>商户订单号</dt>
<dd id="billId"><?php echo $row['trade_no']?></dd>
<dt>创建时间</dt>
<dd id="createTime"><?php echo $row['addtime']?></dd>
</dl>
<a href="javascript:void(0)" class="arrow"><i class="ico-arrow"></i></a>
</div>
<div class="tip">
<span class="dec dec-left"></span>
<span class="dec dec-right"></span>
<div class="ico-scan"></div>
<div class="tip-text">
<p>请使用支付宝扫一扫</p>
<p>扫描二维码完成支付</p>
</div>
</div>
<div class="tip-text">
</div>
</div>
<div class="foot">
<div class="inner">
<div id="J_downloadInteraction" class="download-interaction download-interaction-opening">
	<div class="inner-interaction">
		<p class="download-opening">正在打开支付宝<span class="download-opening-1">.</span><span class="download-opening-2">.</span><span class="download-opening-3">.</span></p>
		<p class="download-asking">如果没有打开支付宝，<a id="J_downloadBtn" href="javascript:;" onclick="openAli();">请点此重新唤起</a></p>
</div>
</div>
</div>
</div>
<script src="assets/js/qcloud_util.js"></script>
<script src="assets/js/jquery-qrcode.min.js"></script>
<script src="assets/layer/layer.js"></script>
<script>
	var code_url = '<?php echo $code_url?>';
    $('#qrcode').qrcode({
        text: code_url,
        width: 230,
        height: 230,
        foreground: "#000000",
        background: "#ffffff",
        typeNumber: -1
    });
    // 订单详情
    $('#orderDetail .arrow').click(function (event) {
        if ($('#orderDetail').hasClass('detail-open')) {
            $('#orderDetail .detail-ct').slideUp(500, function () {
                $('#orderDetail').removeClass('detail-open');
            });
        } else {
            $('#orderDetail .detail-ct').slideDown(500, function () {
                $('#orderDetail').addClass('detail-open');
            });
        }
    });
    // 检查是否支付完成
    function loadmsg() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "getshop.php",
            timeout: 10000, //ajax请求超时时间10s
            data: {type: "wxpay", trade_no: "<?php echo $row['trade_no']?>"}, //post数据
            success: function (data, textStatus) {
                //从服务器得到数据，显示数据并继续查询
                if (data.code == 1) {
					layer.msg('支付成功，正在跳转中...', {icon: 16,shade: 0.01,time: 15000});
					setTimeout(window.location.href=data.backurl, 1000);
                }else{
                    setTimeout("loadmsg()", 4000);
                }
            },
            //Ajax请求超时，继续查询
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                if (textStatus == "timeout") {
                    setTimeout("loadmsg()", 1000);
                } else { //异常
                    setTimeout("loadmsg()", 4000);
                }
            }
        });
    }

	if (typeof AlipayWallet !== 'object') {
		AlipayWallet = {};
	}
	(function () {
		"use strict";
		function a(e, t) {
			for (var o = e.split("."), n = t.split("."), a = 0; a < o.length || a < n.length; a += 1) {
				var r = parseInt(o[a], 10) || 0,
					i = parseInt(n[a], 10) || 0;
				if (r < i) return -1;
				if (r > i) return 1
			}
			return 0
		}
		function r(e) {
			var x = window.document.createElement("iframe"); x.id = "callapp_iframe_" + Date.now(), x.frameborder = "0", x.style.cssText = "display:none;border:0;width:0;height:0;", window.document.body.appendChild(x), x.src = e
		}
		function i(e) {
			var t = x.createElement("a");
			t.setAttribute("href", e), t.style.display = "none", x.body.appendChild(t);
			var o = x.createEvent("HTMLEvents");
			o.initEvent("click", !1, !1), t.dispatchEvent(o)
		}
		function l(e) {
			return /^(http|https)\:\/\//.test(e)
		}
		AlipayWallet.open = function (n){
			var p = window.navigator.userAgent;
			var g = !1,
				m = !1,
				h = "",
				w = p.match(/Android[\s\/]([\d\.]+)/);
			w ? (g = !0, h = w[1]) : p.match(/(iPhone|iPad|iPod)/) && (m = !0, w = p.match(/OS ([\d_\.]+) like Mac OS X/), w && (h = w[1].split("_").join(".")));
			var v = !1,
				b = !1,
				y = !1;
			p.match(/(?:Chrome|CriOS)\/([\d\.]+)/) ? (v = !0, p.match(/Version\/[\d+\.]+\s*Chrome/) && (y = !0)) : p.match(/iPhone|iPad|iPod/) && (p.match(/Safari/) && p.match(/Version\/([\d\.]+)/) ? b = !0 : p.match(/OS ([\d_\.]+) like Mac OS X/) && (y = !0));
			var u = g && v && !y,
				d = g && !! p.match(/samsung/i) && a(h, "4.3") >= 0 && a(h, "4.5") < 0,
				s = m && a(h, "9.0") >= 0 && b;
			if(u){
				var f = n.substring(0, n.indexOf("://")),
					w = "#Intent;scheme=" + f + ";end";
					n = n.replace(/.*?\:\/\//, "intent://"), n += w;
			}
			if (s) {
				setTimeout(function() {
					i(n)
				}, 100)
			} else if (0 === n.indexOf("intent:")) setTimeout(function() {
				window.location.href = n
			}, 100);
			else {
				r(n)
			}
		}
	})();
	function openAli(){
		var scheme = 'alipays://platformapi/startapp?saId=10000007&qrcode=';
		scheme += encodeURIComponent(code_url);
		AlipayWallet.open(scheme);
	}
	window.onload = function(){
		openAli();
		setTimeout("loadmsg()", 2000);
	}
</script>
</body>
</html>