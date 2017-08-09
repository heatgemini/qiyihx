<?php
// +----------------------------------------------------------------------
// | phpWeChat 微信智能机器人自动回复操作类 Last modified 2016/4/24
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------
namespace WeChat;

class Robot
{
	static public function talk($keywords)
	{
		return strip_tags(self::relayPart3("http://api.douqq.com/?key=".WECHAT_XIAODOUBI_KEY."&msg=".trim($keywords)));
	}

	static public function relayPart3($url)
    {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result =  curl_exec($ch);
		curl_close($ch);

		return $result;
    }
}
?>