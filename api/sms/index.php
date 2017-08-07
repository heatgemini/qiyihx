<?php
// +----------------------------------------------------------------------
// | phpWeChat 验证码文件 Last modified 2016/6/22 15:11
// +----------------------------------------------------------------------
// | Copyright (c) 2009-2016 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------

require substr(dirname(__FILE__),0,-8).'/include/common.inc.php';

if(!is_telephone($telephone))
{
	exit('-1');
}

$_SESSION['smscode']=mt_rand(1000,9999);
$send_result=send_checkcode_sms($telephone,$_SESSION['smscode'],$PW);

if($send_result!=2)
{
	exit(2);
}
else
{
	exit($send_result[0]);
}
?>