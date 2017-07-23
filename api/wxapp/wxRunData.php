<?php
	
	require substr(dirname(__FILE__),0,-9).'/include/common.inc.php';
	require_once dirname(__FILE__)."/lib/WxApp.Config.php";
	require_once dirname(__FILE__)."/lib/AccessToken.php";
	require_once dirname(__FILE__)."/lib/WxApp.Api.php";
	require_once dirname(__FILE__)."/lib/WxBizDataCrypt.php";

	$result = array('retcode' => 'SUCCESS', 'retmsg' => '成功');
	$wxAppApi = new WxAppApi();
	$openidObj = $wxAppApi->getOpenid(WxAppConfig::APPID, WxAppConfig::APPSECRET, $_GET['code']);	
	$wxBizDataCrypt = new WxBizDataCrypt(WxAppConfig::APPID, $openidObj['session_key']);
	$errCode = $wxBizDataCrypt->decryptData($_GET['encryptedData'], $_GET['iv'], $data );


	$stepInfoList = json_decode($data)->stepInfoList;

	$stepArray = array();
	foreach ($stepInfoList as $key => $value) {
		$stepArray[date("Y-m-d", $value->timestamp) ] = $value->step;
	}

	echo json_encode($stepArray);
?>



	