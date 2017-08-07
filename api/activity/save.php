<?php
// +----------------------------------------------------------------------
// | phpWeChat 地区读取select文件 Last modified 2016/5/5
// +----------------------------------------------------------------------
// | Copyright (c) 2009-2016 phpWeChat http://www.qiyihx.com All rights reserved.
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
$info['openid'] = $openidObj['openid'];
$info['title'] = $_GET['title'];
$info['detail'] = $_GET['detail'];
$info['date'] = $_GET['date'];
$info['time'] = $_GET['time'];

$result['data'] = Activity::save($info);
exit(json_encode($result));
?>