<?php
// +----------------------------------------------------------------------
// | phpWeChat 地区读取select文件 Last modified 2016/5/5
// +----------------------------------------------------------------------
// | Copyright (c) 2009-2016 phpWeChat http://www.phpwechat.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 骑马的少年 <phpwechat@126.com> <http://www.phpwechat.com>
// +----------------------------------------------------------------------
use phpWeChat\Banner;

require substr(dirname(__FILE__),0,-9).'/include/common.inc.php';

$list = Banner::getList($_GET['type']);
exit(json_encode($list));
?>