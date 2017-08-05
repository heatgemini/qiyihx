<?php
// +----------------------------------------------------------------------
// | phpWeChat 地区读取select文件 Last modified 2016/5/5
// +----------------------------------------------------------------------
// | Copyright (c) 2009-2016 phpWeChat http://www.phpwechat.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 骑马的少年 <phpwechat@126.com> <http://www.phpwechat.com>
// +----------------------------------------------------------------------
use phpWeChat\Wxappcontact;

require substr(dirname(__FILE__),0,-9).'/include/common.inc.php';
require_once substr(dirname(__FILE__),0,-9).'/api/wxapp/lib/WxApp.Config.php';
require_once substr(dirname(__FILE__),0,-9)."/api/wxapp//lib/WxApp.Api.php";


$result = array('retcode' => 'SUCCESS', 'retmsg' => '成功');
$key = $_GET['key'];
$val = $_GET['val'];
$info[$key] = $val;
$info['appid'] = WxAppConfig::APPID;
$wxAppApi = new WxAppApi();
$openidObj = $wxAppApi->getOpenid(WxAppConfig::APPID, WxAppConfig::APPSECRET,$_GET['code']);
$info['openid'] = $openidObj['openid'];

$result['data'] = Wxappcontact::save($info);
exit(json_encode($result));
?>