<?php
/*
 * wx_access_token.php
 * 
 * get the weixin access token 
 * */
if (!defined("DOCUMENT_ROOT")) define("DOCUMENT_ROOT", $_SERVER['DOCUMENT_ROOT']);
if (!defined("__HOME__")) define("__HOME__", dirname(DOCUMENT_ROOT));

require_once("filecache.php");
require_once("HttpUtil.php");

class WxAccessToken{
	public function getToken($appid, $appsecret){
		$wx_access_token_cache_key = 'wxapp_access_token_'. $appid;
		
		$cache = new FileCache(__HOME__ . '/htdocs/data/cache/cachefile.txt');
		$token = $cache->get($wx_access_token_cache_key);
		
		if (!$token){
			$token = $this->getTokenFromWx($appid, $appsecret);
			$cache->set($wx_access_token_cache_key, $token, time()+7000);
		}
		
		return $token;
	}


	public function getTokenFromWx($appid, $appsecret){
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
		$httpUtil = new HttpUtil();
		$result = $httpUtil->sendGet($url);
		return $result["access_token"];
		
	} 
}
?>