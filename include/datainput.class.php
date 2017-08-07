<?php
// +----------------------------------------------------------------------
// | phpWeChat 数据过滤操作类 Last modified 2016/5/714:20
// +----------------------------------------------------------------------
// | Copyright (c) 2009-2016 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>

// +----------------------------------------------------------------------

namespace phpWeChat;

class DataInput
{	
	static public function filterData(&$info)
	{
		foreach($info as $key => $val)
		{
			$info[$key]=$val;
		}
	}
}
?>