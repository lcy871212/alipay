<?php 
namespace Lcy\Alipay\Web;
use Lcy\Alipay\Aop\AopClient;
use Lcy\Alipay\Aop\Request\AlipayTradePagePayRequest;


class SdkPayment
{
	private $gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	private $appid;
	private $app_private_key;//你的应用私钥
	private $alipayrsaPublicKey;//你的支付宝公钥
	private $format = 'json';
	private $charset = 'UTF-8';
	private $signType = 'RSA2';

	public function __construct()
	{
		
	}
	/**
	 * 设置应用APPID
	 * @param [type] $APPID [description]
	 */
	public function setAppid($appid)
	{
		$this->appid = $appid;
		return $this;
	}
	/**
	 * 设置开发者私钥
	 * @param [type] $APPID [description]
	 */
	public function setAppPrivateKey($key_str)
	{
		$this->app_private_key = $key_str;
		return $this;
	}
	/**
	 * 设置支付宝公钥
	 * @param string $value [description]
	 */
	public function setAppPublicKey($key_str)
	{
		$this->alipayrsaPublicKey = $key_str;
		return $this;
	}

	/**
	 * 设置编码格式
	 */
	public function charset($charset)
	{
		$this->charset=$charset;
		return $this;
	}

	 

	/**
	 * 实例化aop
	 * @return [type] [description]
	 */
	public function initAlipayAopClient()
	{
		$aop = new AopClient ();
		$aop->gatewayUrl = $this->gatewayUrl;
		$aop->appId = $this->appid;
		$aop->rsaPrivateKey = $this->app_private_key;
		$aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;
		$aop->apiVersion = '1.0';
		$aop->signType = $this->signType;
		$aop->postCharset = $this->charset;
		$aop->format = $this->format;
		return $aop;
	}
	
	/**
	 * 发送一笔交易数据
	 * @return [type] [description]
	 * $data为数组格式 data数据参考 https://docs.open.alipay.com/api_1/alipay.trade.page.pay
	 */
	public function sendAlipayTradePagePayRequest($data)
	{
		if ($data && is_array($data)) {	
			if (!isset($data['product_code'])) {
				$data=array_merge($data,['product_code'=>'FAST_INSTANT_TRADE_PAY']);
			}
			$data=json_encode($data); 
			$aop=$this->initAlipayAopClient();
			$res = new AlipayTradePagePayRequest();
			$res->setBizContent($data);
			$res->setNotifyUrl(env('ALIPAY_notify_url'));
			$res->setReturnUrl(env('ALIPAY_return_url'));
			$result = $aop->pageExecute($res);
			return $result;
		}
	}
 


}
 ?>