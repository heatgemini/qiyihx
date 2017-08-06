<?php
	
	require substr(dirname(__FILE__),0,-9).'/include/common.inc.php';
	require_once dirname(__FILE__)."/lib/WxApp.Api.php";

	$result = array('retcode' => 'SUCCESS', 'retmsg' => '成功');

	$wxAppApi = new WxAppApi();
	$wxAppApi->getWxacodeUnlimit($_GET['scene'], $_GET['page'],$_GET['width'],
		$_GET['auto_color'], $_GET['r'], $_GET['g'], $_GET['g']);
?>