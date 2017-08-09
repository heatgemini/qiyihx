<?php
// +----------------------------------------------------------------------
// | phpWeChat 会员系统管理配置入口文件 Last modified 2016/5/25 21:49
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------
use phpWeChat\Config;

!defined('IN_MANAGE') && exit('Access Denied!');

$mod='member';
$file=@return_edefualt(str_callback_w($_GET['file']),'config');
$action=@return_edefualt(str_callback_w($_GET['action']),'config');

switch($action)
{
	case 'config':
		if(isset($dosubmit))
		{
			Config::setConfig($mod,$info);
			operation_tips('参数配置成功！');
		}
		
		include_once parse_admin_tlp($file.'-'.$action,'member');
		break;
}
?>