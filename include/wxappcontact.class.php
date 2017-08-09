<?php

// +----------------------------------------------------------------------
// | phpWeChat 会员操作类 Last modified 2016/5/25 21:33
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------

namespace phpWeChat;

class Wxappcontact
{

	private static $wxappContactTable='wxapp_contact';
	public static $mPageString='';
	public static $mTotalPage=0;


	public static function save($info)
	{
		if(!trim($info['openid']))
		{
			return -1;
		}

		$r=self::findByOpenid($info['openid']);
		if($r)
		{
			$info['update_time'] = time();
			return MySql::update(DB_PRE.self::$wxappContactTable,$info,"openid='".$r['openid']."'");
		}
		else
		{
			$info['create_time'] = time();
			$info['id'] = md5(time() . mt_rand(0,1000));
			return MySql::insert(DB_PRE.self::$wxappContactTable,$info);
		}
	}

	public static function find($id='',$f='') 
	{
		
		if(!$id)
		{
			return MySql::fetchAll("SELECT * FROM `".DB_PRE.self::$wxappContactTable."` ORDER BY `".DB_PRE.self::$wxappContactTable."`.`id` ASC");
		}
		else
		{
			$r=MySql::fetchOne("SELECT * FROM `".DB_PRE.self::$wxappContactTable."` WHERE `".DB_PRE.self::$wxappContactTable."`.`id`='$id'");
	
			if(!$f)
			{
				return $r;
			}
			return isset($r[$f])?$r[$f]:$r;
		}

	}

	public static function findByOpenid($openid='',$f='') 
	{
		
		if(!$openid)
		{
			return MySql::fetchAll("SELECT * FROM `".DB_PRE.self::$wxappContactTable."` ORDER BY `".DB_PRE.self::$wxappContactTable."`.`openid` ASC");
		}
		else
		{
			$r=MySql::fetchOne("SELECT * FROM `".DB_PRE.self::$wxappContactTable."` WHERE `".DB_PRE.self::$wxappContactTable."`.`openid`='$openid'");
	
			if(!$f)
			{
				return $r;
			}
			return isset($r[$f])?$r[$f]:$r;
		}

	}

}