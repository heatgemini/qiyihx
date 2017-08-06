<?php
require_once dirname(__FILE__)."/WxApp.Config.php";
require_once dirname(__FILE__)."/HttpUtil.php";
require_once dirname(__FILE__)."/AccessToken.php";

/**
 * 
 * 接口访问类，包含所有微信支付API列表的封装，类中方法为static方法，
 * 每个接口有默认超时时间（除提交被扫支付为10s，上报超时时间为1s外，其他均为6s）
 * @author widyhu
 *
 */
class WxAppApi
{
	/**
	 * 
	 * 获取sessionkey
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return 成功时返回，其他抛异常
	 */
	public static function getOpenid($appid, $appsecret, $js_code, $timeOut = 6)
	{
		$url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$appsecret&js_code=$js_code&grant_type=authorization_code";
		$httpUtil = new HttpUtil();
		$result = $httpUtil->sendGet($url);
		return $result;
	}

	/**
	 * 发送模版消息
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return 成功时返回，其他抛异常
	 */
	public static function sendTplMsg($touser, $template_id, $form_id, $data, $timeOut = 6)
	{
		$tplParam = array(
			'touser'=>$touser, 
			'template_id'=>$template_id, 
			'form_id'=>$form_id, 
			'data'=>$data
			);
		$wxAccessToken = new WxAccessToken();
		$access_token = $wxAccessToken->getToken(WxAppConfig::APPID, WxAppConfig::APPSECRET);
		$url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=$access_token";
		$httpUtil = new HttpUtil();
		$result = $httpUtil->sendPost($url, json_encode($tplParam));
		return $result;
	}


	/**
	 * 获取小程序码
	 * @param String $scene
	 * @param String $page - pages/index/index
	 * @param int $width - 430
	 * @param Bool $auto_color - false
	 * @param Object $line_color - {"r":"0","g":"0","b":"0"}
	 * @param int $timeOut
	 * @throws WxPayException
	 * @return 成功时返回，其他抛异常
	 */
	public static function getWxacodeUnlimit($scene, $page, $width, $auto_color=false, $r="0" ,$g="0", $b="0", $timeOut = 6)
	{
		if($scene == null){
			$scene ="";
		}
		if($page == null){
			$page ="pages/index/index";
		}
		if($width == null){
			$width = 430;
		}
		$line_color = array('r' => $r, 'g' => $g, 'b' => $b);
		$wxacodeParam = array(
			'scene'=>$scene
			//,page'=>$page 
			//,'width'=>$width
			//'auto_color'=>$auto_color
			//,'line_color'=>$line_color
			);
		//return $wxacodeParam;
		$wxAccessToken = new WxAccessToken();
		$access_token = $wxAccessToken->getToken(WxAppConfig::APPID, WxAppConfig::APPSECRET);
		$url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=$access_token";
		$httpUtil = new HttpUtil();
		$result = $httpUtil->sendPostString($url, json_encode($wxacodeParam));
		return $result;
	}
	
}

