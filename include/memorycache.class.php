<?php
// +----------------------------------------------------------------------
// | phpWeChat Memory缓存操作类 Last modified 2016/4/26 18:01
// +----------------------------------------------------------------------
// | Copyright (c) 2009-2016 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------
namespace phpWeChat;

class MemoryCache
{
	static private $mMemoryTable='mem_cache';

	static public function set($key, $value, $ttl = 0)
    {
		global $PW;

		$ttl=intval($ttl)?intval($ttl):$PW['cache_ttl'];
		
		$mem=array();

		$mem['key']=pw_md5($key);
		$mem['value']=addslashes(trim($value));
		$mem['expire']=CLIENT_TIME+$ttl;
		
		return MySql::insert(DB_PRE.self::$mMemoryTable,$mem,true);
	}

	static public function get($key)
	{
		$r=MySql::fetchOne("SELECT * FROM ".DB_PRE.self::$mMemoryTable." WHERE `key`='".pw_md5($key)."'");
	
		if($r)
		{
			if($r['expire'] > CLIENT_TIME)
			{
				return stripslashes($r['value']);
			}

			self::rm($key);
			return '';
		}

		return '';
	}

	static public function rm($key)
    {
		$key=pw_md5($key);
		return MySql::query("DELETE FROM `".DB_PRE.self::$mMemoryTable."` WHERE `key`='$key' AND `expire`<".CLIENT_TIME,true);
    }

    static public function clear()
    {	
		return 	MySql::query("TRUNCATE TABLE `".DB_PRE.self::$mMemoryTable."`",true);
    }
}