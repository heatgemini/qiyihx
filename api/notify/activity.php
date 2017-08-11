<?php
// +----------------------------------------------------------------------
// | phpWeChat 地区读取select文件 Last modified 2016/5/5
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------
use phpWeChat\Activity;

require dirname(__FILE__).'/../../include/common.inc.php';
require_once dirname(__FILE__).'/../wxapp/lib/WxApp.Config.php';
require_once dirname(__FILE__).'/../wxapp/lib/WxApp.Api.php';

$result = array('retcode' => 'SUCCESS', 'retmsg' => '成功');

$datetime = strtotime("+10 minutes");
$date = date("Y-m-d",$datetime);
$time = date("H:i",$datetime);

$activitys = Activity::findJoinNotify($date, $time);

foreach ($activitys as $key => $activity) {
	
	$value1 = array('value' => $activity['title'],'color' => '#000000');
	$value2 = array('value' => $activity['date'] . ' '. $activity['time'],'color' => '#000000');
	$value3 = array('value' => $activity['location'],'color' => '#000000');
	$value4 = array('value' => '准时到现场哦','color' => '#000000');

	$data = array('keyword1' => $value1,'keyword2' => $value2,'keyword3' => $value3,'keyword4' => $value4);
	print(json_encode($data));
	$wxAppApi = new WxAppApi();
	$result['result'] = $wxAppApi->sendTplMsg($activity['openid'], WxAppConfig::WX_TPL_MSG_ACTIVITY_BEGIN_NOTIFY, $activity['form_id'], $data, $timeOut = 6);
	print(json_encode($result));
}

exit(json_encode($result));
?>