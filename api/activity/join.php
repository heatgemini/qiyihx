<?php
// +----------------------------------------------------------------------
// | phpWeChat 地区读取select文件 Last modified 2016/5/5
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------
use phpWeChat\Activity;

require substr(dirname(__FILE__),0,-13).'/include/common.inc.php';
require_once substr(dirname(__FILE__),0,-13).'/api/wxapp/lib/WxApp.Config.php';
require_once substr(dirname(__FILE__),0,-13)."/api/wxapp//lib/WxApp.Api.php";


$result = array('retcode' => 'SUCCESS', 'retmsg' => '报名成功');

// 获取OPENID
$wxAppApi = new WxAppApi();
$openidObj = $wxAppApi->getOpenid(WxAppConfig::APPID, WxAppConfig::APPSECRET,$_GET['code']);
$info['openid'] = $openidObj['openid'];
$info['activity_id'] = $_GET['activity_id'];
$info['user_name'] = $_GET['user_name'];
$info['form_id'] = $_GET['form_id'];

// 查询是否已经报名
$activity = Activity::findJoinByActivityIdAndOpenid($info['activity_id'], $info['openid']);
if($activity)
{
	$result['retcode'] = "EXIST";
	$result['retmsg'] = "报名已成功";
}else{
	// 报名活动
	$result['data'] = Activity::saveJoin($info);
	if($result['data'] != 0){
		$result['retcode'] = "FAIL";
		$result['retmsg'] = "失败";
	}
}
exit(json_encode($result));
?>