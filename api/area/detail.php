<?php
// +----------------------------------------------------------------------
// | phpWeChat 地区读取select文件 Last modified 2016/5/5
// +----------------------------------------------------------------------
// | Copyright (c) 2009-2016 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------
use phpWeChat\Wxappcontact;

require substr(dirname(__FILE__),0,-9).'/include/common.inc.php';
require_once substr(dirname(__FILE__),0,-9).'/api/wxapp/lib/WxApp.Config.php';
require_once substr(dirname(__FILE__),0,-9)."/api/wxapp//lib/WxApp.Api.php";

$result = array('retcode' => 'SUCCESS', 'retmsg' => '成功');

$result['data'] = Wxappcontact::find($_GET['id']);
exit(json_encode($result));
?>