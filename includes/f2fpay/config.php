<?php
$config = array (
	//签名方式,默认为RSA2(RSA2048)
	'sign_type' => "RSA2",

	//支付宝公钥
	'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkY2WMBxc/8fGDMItNVUGUqhUk1ojev+1AekZtJofvii76bzcMDwoaXRLL7E7i9IMcDTzB52h8ODDO27dG4ADtkM5+L3QBUFwVVvQcEz7YiGny4uyIAnC2uI3uYzX+IuVwoH+ayTy7NvqQovxR7E9Ouf8QQ3s+FG0DVRUZ/ZtaiA4qQYcb1FYpoT2gzB6ODC1NEFxT+yHn9kYwzMA6CsTr8UaKzkzupzitFqJ7m0/dSydcK73yKKTyvNaYs3komUfZI5b+lDTwJKt0PRo+WQcQpPd3bXRx4H/7f2f986+ItkxN9IfM3LSwHNPNEfzKG2hWTWfoaJtx5E70sAoZYrJ/wIDAQAB",

	//商户私钥
	'merchant_private_key' => "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCaGd2g0G1yN7BvLl6enbbECn2KzO6VbcLooddTkS0QGcWyay9Zfl+VDOoVxtLfzP/vk/oidWS4DoOMxxXBKg9vYgzsYTDmhVOf8MxN/sjjKRyhzj3t+1RTlOsjxCqqq8YgxZj9p3Otj0i7H6AOMcJP9nIqBvloe1+A9Q1ifZi2aKKrzyx3GM3npez8FiZjY/9q7EdChlQjtXQ2dAq5CkulLR6dwBbsSPNvxFXxXEUpCMwFOMXlSvpYZhdZXhEiBDxixW49vGhTE3xOxbIOwNewreq3mjF48drKMYhZnjTq5GzIS3KHeKwi2fq/dR55ZKaCunLiz/02iiFL7bNPknW9AgMBAAECggEAKdBw8ez8daykxFZpuFKFQEa0cBBRgNyKscMQgY14E9FacqJg88C1wOUDM6uCltWycNjPW8BM9yCBE5cF0SdPjuKlLRLmSPbOjSyy00saSYFjUoh7B3NWG2PiNg9JoIwBs+zKKbHhUqv5iUT4kkFwP3BY5AyGapJnhL95xUrdQElSSCEKjaE4psmWggxbnhAJhlwRWAI5bmFz3Zkyvkxky5uK2aOPxRzI9QePvzmC+XZBRJH2rTS3hWLsdA5sLd9meK0nWuu440j5bkfVfUFjY7My4jrKFsqrFiXampn0AV9SgAJHnr3oLmKUS1yjMfSmerqHyirjVmCu8EONNUsFoQKBgQDQdg6msKEs9CJ6ll8LBXgtVkNQWZmBi4QQdcc/ezMaocWJ8Fd/6/D79r016+4ua1qv+jkT5TKSxZMNHnyAXx3E1yg+djAoOwrRWsyxpDxalEWibkyGfvHfVx6StX7t25gBoKUNol3y+eaWkVqZyxqWVPyxbulJ3iZ7lmJtmvSXhQKBgQC9PkUKSwbc0rdpTe907mqf4H7gInigxsPR5NnC6eWZq6hTjF1E1cDApFZVdh3M/eV3FZc8bXuuh1+S46xepTjkZ7Ozf+2CzcSfgTSs56lnktjoDxAUA56rJw0EhQ/+s7GJS3v18kiIH67t/d1FSaaUHEdt6x4AeVdDK72bhV3O2QKBgBVS/kyu5M3ka2J+31oRRSneGSSvBbTqwKeuZKNpxuCCi+KAY3MCf7RGmTRa3hKBiNVXk18lovbAnzpIVBQNps3r9IHvNR3obELeNvI1Crd5U2Y6Qjm/4p4mG0qGpmVOgU4pULkEUvf3+E6Or+XrkNyv9OlxnwufXfBmgcsUftDBAoGAcRqDZuh6fIZP6lcTE77e6Rjim5DeqbDCHnN5lt32RMbsfqq4n8hlQH23v7Itk3P3rhmwXwRMVH5CJ+d9AMAc5Z35MAH4cSIMLwyo7+IxRF7m1qMSB/Q147MeO6JPcfnx1M3Rk6gvo3PUOBdvJNclAQZ5xn8sWjorZlEBLK8j5tkCgYEAuf8B2694EJNUxDy2EcRxqO+yLffxmGBdoZpLeoqBuV0QGckcyRhA8FufM6K+RJCC6p9biikYd3kW/5tAek8Q6bvMRCBcLCYL8ypTYYk7JQLruTzLAHWXi5nwbLAd40yz8IDa+JCT8RK+FRsoVZIpkdYbbd/IoRoAMTBR371JD9I=",

	//编码格式
	'charset' => "UTF-8",

	//支付宝网关
	'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

	//应用ID
	'app_id' => "2017060707441959",

	//异步通知地址,只有扫码支付预下单可用
	'notify_url' => 'http://'.$conf['local_domain'].'/f2fpay_notify.php',

	//登录返回页面
	'redirect_uri' => ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].'/user/oauth.php',
);