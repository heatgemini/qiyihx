<?php
// +----------------------------------------------------------------------
// | phpWeChat 验证码文件 Last modified 2016-03-25 16:45
// +----------------------------------------------------------------------
// | Copyright (c) 2009-2016 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------
use phpWeChat\Captcha;

require substr(dirname(__FILE__),0,-12).'/include/common.inc.php';

Captcha::setCaptcha(CAPTCHA_WIDTH,CAPTCHA_HEIGHT,CAPTCHA_LEN);
Captcha::drawCaptcha();
?>