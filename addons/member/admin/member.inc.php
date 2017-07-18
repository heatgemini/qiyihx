<?php
// +----------------------------------------------------------------------
// | phpWeChat 会员系统管理配置入口文件 Last modified 2016/5/25 21:49
// +----------------------------------------------------------------------
// | Copyright (c) 2009-2016 phpWeChat http://www.phpwechat.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 骑马的少年 <phpwechat@126.com> <http://www.phpwechat.com>
// +----------------------------------------------------------------------
use phpWeChat\Member;

!defined('IN_MANAGE') && exit('Access Denied!');

$mod='member';
$file=@return_edefualt(str_callback_w($_GET['file']),'member');
$action=@return_edefualt(str_callback_w($_GET['action']),'member');

switch($action)
{
	/**
	 * 会员管理操作
	 */
	case 'member':
		$username=htmlspecialchars(trim($username));
		$data=Member::memberList($username,20);
		include_once parse_admin_tlp($file.'-'.$action,'member');
		break;
	case 'member_pwd':
		$userid=intval($userid);
		$data=Member::getUserByUserId($userid);

		if(!$data)
		{
			operation_tips('指定会员不存在 [-2]！','','error');
		}

		if(isset($dosubmit))
		{
			$newpassword=trim($newpassword);

			if($newpassword && !is_pwd($newpassword))
			{
				operation_tips('密码格式不正确 [-1]！','','error');
			}

			if($newpassword)
			{
				Member::memUpdate($userid,array('userpwd'=>md5($newpassword)));
				operation_tips('会员密码重置成功！','?mod=member&file=member&action=member');
			}
			else
			{
				operation_tips('会员密码重置成功（无更改）！','?mod=member&file=member&action=member');
			}
		}
		
		include_once parse_admin_tlp($file.'-'.$action,'member');
		break;
	/*
		会员余额、积分、登录日志
	*/
	case 'amount_log':
		$userid=intval($userid);
		$data=Member::amountLogList($userid,20);
		include_once parse_admin_tlp($file.'-'.$action,'member');
		break;
	case 'amount_log_clear':
		Member::amountLogClear();
		operation_tips('操作成功');
		break;
	case 'credits_log':
		$userid=intval($userid);
		$data=Member::creditsLogList($userid,20);
		include_once parse_admin_tlp($file.'-'.$action,'member');
		break;
	case 'credits_log_clear':
		Member::creditsLogClear();
		operation_tips('操作成功');
		break;
	case 'login_log':
		$userid=intval($userid);
		$data=Member::loginLogList($userid,20);
		include_once parse_admin_tlp($file.'-'.$action,'member');
		break;
	case 'login_log_clear':
		Member::loginLogClear();
		operation_tips('操作成功');
		break;
	/**
	 * 会员等级操作
	 */
	case 'level':
		if(isset($dosubmit))
		{
			if($levelid)
			{
				$op=Member::levelEdit($info,$levelid);
			}
			else
			{
				$op=Member::levelAdd($info);
			}

			if($op>0)
			{
				operation_tips('会员等级'.($levelid?'编辑':'添加').'成功！','?mod=member&file=member&action=level');
			}
			else
			{
				operation_tips('操作失败 ['.$op.']！','','error');
			}
		}

		if(isset($job))
		{
			switch($job)
			{
				case 'delete':
					Member::levelDelete($levelids);
					operation_tips('会员等级删除成功！');
					break 2;
			}
		}

		$data=array();

		if($levelid)
		{
			$data=Member::levelGet($levelid);
		}
		include_once parse_admin_tlp($file.'-'.$action,$mod);
		break;
}
?>