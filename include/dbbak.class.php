<?php
// +----------------------------------------------------------------------
// | phpWeChat 数据库备份类 Last modified 2016/7/4 17:05
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME<616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------
namespace phpWeChat;

class dbBak
{
	static public function tablesList()
	{
		$result=MySql::getTableStatus(DB_NAME);
		foreach($result as $key => $value)
		{
			if(substr($value['Name'],0,strlen(DB_PRE))==DB_PRE)
			{
				$result[$key]=$value;
			}
			else 
			{
				unset($result[$key]);
			}
		}
		return $result;
	}
}
?>