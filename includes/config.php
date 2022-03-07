<?php
/*数据库配置*/
$dbconfig=array(
	'host' => 'localhost', //数据库服务器
	'port' => 3306, //数据库端口
	'user' => 'root', //数据库用户名
	'pwd' => 'root', //数据库密码
	'dbname' => 'auth' //数据库名
);

/*网站配置*/
$conf=array(
	'admin_user' => 'admin', //管理员用户名
	'admin_pwd' => 'admin', //管理员密码
	'local_domain' => 'mpay.v8jisu.cn', //本站URL最好不开CDN

	/*结算转账信息设置*/
	'wxtransfer_desc' => '彩虹易支付自动结算', //微信企业付款 付款说明
	'payer_show_name' => '彩虹易支付', //单笔转账到支付宝接口 付款方显示姓名
	'alipay_appid' => '2016070101572878', //支付宝应用APPID

	/*支付及结算费率设置*/
	'money_rate' => 97, //默认支付分成比例（百分数）
	'settle_money' => 30, //每天满多少元自动结算
	'settle_rate' => 0.005,  //结算费率
	'settle_fee_min' => 0.1,  //结算手续费最小
	'settle_fee_max' => 20,  //结算手续费最大
	'settle_open' => 0,  //是否开启用户中心手动申请结算

	/*用户中心配置*/
	'web_name' => '彩虹易支付', //网站名称
	'web_qq' => '1277180438', //客服QQ
	'quicklogin' => 1, //快捷登录设置（1为支付宝快捷登录，2为QQ快捷登录）

	/*申请商户配置*/
	'is_reg' => 1, //是否开放自助申请商户
	'is_payreg' => 1, //是否付费申请
	'reg_pid' => '1000', //付费申请收款商户ID
	'reg_price' => '5', //商户申请价格
	'verifytype' => 1, //0为邮箱验证，1为手机验证
	'stype_1' => 1, //是否开启支付宝结算
	'stype_2' => 1, //是否开启微信结算
	'stype_3' => 1, //是否开启QQ钱包结算
	'stype_4' => 0, //是否开启银行卡结算

	/*发信邮箱配置*/
	'mail_cloud' => 0, //0为使用SMTP发信，1为使用sendcloud
	'mail_smtp' => 'smtp.qq.com', //SMTP地址
	'mail_port' => 465, //SMTP端口
	'mail_name' => '65850510@qq.com', //邮箱账号
	'mail_pwd' => '123456', //邮箱密码（授权码）
	'mail_apiuser' => '', //sendcloud API_USER
	'mail_apikey' => '', //sendcloud API_KEY

	/*短信验证码配置*/
	'sms_appkey' => '', //admin.978w.cn【我的接口】页面查看

	/*Geetest极限验证码配置*/
	'CAPTCHA_ID' => 'b31335edde91b2f98dacd393f6ae6de8',
	'PRIVATE_KEY' => '170d2349acef92b7396c7157eb9d8f47',

);

?>