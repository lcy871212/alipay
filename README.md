Alipay
======

支付宝SDK在Laravel5封装包。

该拓展包想要达到在Laravel5框架下，便捷使用支付宝的目的。

## 安装
```
composer require lcy871212/alipay
```

## 使用

要使用支付宝SDK服务提供者，你必须自己注册服务提供者到Laravel服务提供者列表中。
基本上有两种方法可以做到这一点。

找到 `config/app.php` 配置文件中，key为 `providers` 的数组，在数组中添加服务提供者。


```php
    'providers' => [
        // ...
        Lcy\Alipay\AlipayServiceProvider::class,
    ]
```

## 配置请求参数

对应在env文件中设置ALIPAY_appId（应用appid）、ALIPAY_rsaPrivateKey(应用私钥)、ALIPAY_alipayrsaPublicKey(支付宝公钥)、ALIPAY_notify_url(异步通知回调)、ALIPAY_return_url(同步通知回调)


## 调取示例
```php
	namespace App\Http\Controllers;
	use Illuminate\Http\Request;
	class IndexController extends Controller
	{
	   public function index(Request $request)
	   {
	   	 $A=app('alipay.web');
	   	 $data=[
	   	 	'out_trade_no'=>'US20150320010101001',
	   	 	'trade_no'=>md5(uniqid()),
	   	 	'subject'=>"这个是个支付测试",
	         'body'=>'这个是测试的描述部分',
	         'timeout_express'=>'30m',//30分钟内支付
	   	 	'total_amount'=>88.88,
	   	 	'qr_pay_mode'=>4,
	         'passback_params'=>'',//公共参数，回调时也会显示此参数
	   	 ];
	   	 $result=$A->sendAlipayTradePagePayRequest($data);
	   	 var_dump( $result) ;
	   }
	}
```
