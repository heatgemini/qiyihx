<?php

// +----------------------------------------------------------------------
// | phpWeChat 会员操作类 Last modified 2016/5/25 21:33
// +----------------------------------------------------------------------
// | Copyright (c) 2009-2016 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------

namespace phpWeChat;

class Activity
{

	private static $activityTable='activity';
	public static $mPageString='';
	public static $mTotalPage=0;


	public static function save($info)
	{
		if(!trim($info['openid']))
		{
			return -1;
		}

		if(trim($info['id']))
		{
			$info['update_time'] = time();
			return MySql::update(DB_PRE.self::$activityTable,$info,"id='".$r['id']."'");
			
		}
		else{
			$info['id'] = md5(time() . mt_rand(0,1000));
			$info['create_time'] = time();
			return MySql::insert(DB_PRE.self::$activityTable,$info);
		}
	}

	public static function find($id='',$f='') 
	{
		
		if(!$id)
		{
			return MySql::fetchAll("SELECT * FROM `".DB_PRE.self::$activityTable."` ORDER BY `".DB_PRE.self::$activityTable."`.`id` ASC");
		}
		else
		{
			$r=MySql::fetchOne("SELECT * FROM `".DB_PRE.self::$activityTable."` WHERE `".DB_PRE.self::$activityTable."`.`id`='$id'");
	
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
			return MySql::fetchAll("SELECT * FROM `".DB_PRE.self::$activityTable."` ORDER BY `".DB_PRE.self::$activityTable."`.`openid` ASC");
		}
		else
		{
			$r=MySql::fetchOne("SELECT * FROM `".DB_PRE.self::$activityTable."` WHERE `".DB_PRE.self::$activityTable."`.`openid`='$openid'");
	
			if(!$f)
			{
				return $r;
			}
			return isset($r[$f])?$r[$f]:$r;
		}

	}

}