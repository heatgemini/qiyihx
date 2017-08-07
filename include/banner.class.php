<?php

// +----------------------------------------------------------------------
// | phpWeChat 会员操作类 Last modified 2016/5/25 21:33
// +----------------------------------------------------------------------
// | Copyright (c) 2009-2016 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------

namespace phpWeChat;

class Banner
{

	private static $mBannerTable='banner';
	public static $mPageString='';
	public static $mTotalPage=0;

	public static function getList($type, $status, $pagesize=20)
	{	
		$where='1';
		$where.=$type?' AND type = '.$type:'';
		$where.=$status?' AND status = '.$status:'';

		$orderby='`sort` DESC';

		$result=DataList::getList(DB_PRE.self::$mBannerTable,$where,$orderby,max(isset($_GET['page'])?intval($_GET['page']):1,1),intval($pagesize),0,'right');

		self::$mPageString=DataList::$mPageString;
		self::$mTotalPage=DataList::$mTotalPage;
		return $result;
	}

}