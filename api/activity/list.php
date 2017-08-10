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

$result = array('retcode' => 'SUCCESS', 'retmsg' => '成功');

$wxAppApi = new WxAppApi();
$openidObj = $wxAppApi->getOpenid(WxAppConfig::APPID, WxAppConfig::APPSECRET,$_GET['code']);
$result['data'] = Activity::getList($_GET['status'], $openidObj['openid']);
exit(json_encode($result));
?>