<?php
	
	require substr(dirname(__FILE__),0,-9).'/include/common.inc.php';
	require_once dirname(__FILE__)."/lib/WxApp.Config.php";
	require_once dirname(__FILE__)."/lib/AccessToken.php";
	require_once dirname(__FILE__)."/lib/WxApp.Api.php";

	$result = array('retcode' => 'SUCCESS', 'retmsg' => '成功');
	$wxAppApi = new WxAppApi();
	$openidObj = $wxAppApi->getOpenid(WxAppConfig::APPID, WxAppConfig::APPSECRET,$_GET['code']);

	$result['openid'] = $openidObj;
	$formId = $_GET['formId'];

	$wxAccessToken = new WxAccessToken();
	$result['access_token'] = $wxAccessToken->getToken(WxAppConfig::APPID, WxAppConfig::APPSECRET);
	$value1 = array('value' => '【初梦】我依然在这里...','color' => '#000000');
	$value2 = array('value' => '生活','color' => '#000000');
	$value3 = array('value' => '审核通过','color' => '#000000');
	$datetime = new DateTime();
	$value4 = array('value' => $datetime->format('Y-m-d H:i:s'),'color' => '#000000');
	$value5 = array('value' => '恭喜您，现在可以在【奇异幻想】小程序中查看您发布的内容啦！！！','color' => '#000000');
	
	$data = array('keyword1' => $value1,'keyword2' => $value2,'keyword3' => $value3,'keyword4' => $value4,'keyword5' => $value5);
	$result['result'] = $wxAppApi->sendTplMsg($openidObj['openid'], WxAppConfig::WX_TPL_MSG_VERIFY, $form_id, $data, $timeOut = 6);

	$jsonstring = json_encode($result);
	header('Content-Type: application/json'); 
	echo $jsonstring;


?>