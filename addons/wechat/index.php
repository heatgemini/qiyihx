<?php

	use Wechat\WeChatManage;

	use Wechat\Wechat;

	

	!defined('IN_APP') && exit('Access Denied!');

	switch($action)

	{

		case 'auth20':

			if(trim($redirect_url))

			{

				set_cookie('redirect_url',trim($redirect_url));

			}

			// 获取openid
			$openid=WeChat::getOpenID();

			//判断该openid是否已关注或者是否已有头像信息
			$fansinfo=WeChat::getFansByOpenid($openid);

			if(!$fansinfo['headimgurl'])
			{
				WeChat::wechatAuth(U(MOD,'auth20'),trim($redirect_url));
			}
			else
			{
				//print_r($_SESSION);exit();
				header("location:".format_url(urlsafe_b64decode($redirect_url)));
				exit();
			}
			exit();

			break;

		case 'tel':

			break;

		case 'map':

			break;

		case 'view':
			$id=intval($id);
			$data=WeChatManage::getMaterial($id);
			if(!$data)
			{
				wealert("参数错误");
			}

			WeChatManage::setMaterial(array('Clicks'=>$data['Clicks']+1),$id);
			break;

		default:

			WeChat::run($PW['wechat_token']);

			break;

	}

?>