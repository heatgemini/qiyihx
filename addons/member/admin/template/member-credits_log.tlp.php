{php !defined('IN_MANAGE') && exit('Access Denied!');use phpWeChat\Member;use phpWeChat\MySql;use phpWeChat\Ip;}

<!doctype html>

<html>

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>phpWeChat后台管理</title>

    <link rel="stylesheet" type="text/css" href="{__PW_PATH__}admin/template/css/common.css"/>

    <link rel="stylesheet" type="text/css" href="{__PW_PATH__}admin/template/css/main.css"/>

    <link rel="stylesheet" type="text/css" href="{__PW_PATH__}statics/core.css"/>

    <link rel="stylesheet" type="text/css" href="{__PW_PATH__}statics/reveal/reveal.css"/>
  	<script language="javascript" type="text/javascript">
		var PW_PATH='{__PW_PATH__}';

	</script>
	<script src="{__PW_PATH__}statics/jquery/jquery-1.12.2.min.js" language="javascript"></script>

    <script src="{__PW_PATH__}statics/reveal/jquery.reveal.js" language="javascript"></script>

	<script src="{__PW_PATH__}statics/core.js" language="javascript"></script>

    <script type="text/javascript" src="{__PW_PATH__}admin/template/js/libs/modernizr.min.js"></script>

  

</head>

<body>

    <div class="ifame-main-wrap">

        <div class="crumb-wrap">

            <div class="crumb-list"><i class="icon-font"></i><a href="{__PW_PATH__}{__ADMIN_FILE__}?file=index&action=main">管理首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">会员日志管理</span></div>

        </div>

        <div class="result-wrap">

                <div class="config-items">
					<div class="admin-nav">

                        <h2>会员日志管理</h2>

                        <div class="nav">
							<a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action=login_log">登录日志</a>
                            <a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action={$action}" class="hover">积分日志</a>
							<a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action=amount_log">余额日志</a>
                        </div>

                    </div>
					<div style="border: 1px solid #F3F3F3; padding:8px; margin:8px 0px">

					  <form name="seatchform" method="post" action="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action={$action}">

						按用户ID检索：

						<input type="text" class="common-text" name="userid" size="32" />

						<input type="submit" value="搜 索" class="common_btn">
						&nbsp;&nbsp;&nbsp;
						<a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action={$action}_clear">清除30天前的日志</a>
					  </form>
						
					</div>

                    <div class="result-content">

                        <table class="result-tab" width="100%">

						  <tr>

							<th>UserID</th>

							<th>会员名</th>

							<th>积分变动时间</th>

							<th>积分变动数量</th>

							<th>详情</th>
						  </tr>

						  {loop $data $r}

							<tr>

								<td>{$r['userid']}</td>

								<td>{Member::getUserByUserId($r['userid'],'username')}</td>

								<td>{date('Y-m-d H:i:s',$r['creditstime'])}</td>

								<td>{php echo $r['inc']>0?'<font style="color:#009933;">增加</font>':'<font style="color:#FF3300;">减少</font>';} <font style="color:#009933; font-weight:bold">{$r['credits']}</font> 积分</td>

								<td>{$r['desc']}</td>

							</tr>

						 {/loop}

						 <tr>

							<td colspan="5">

								{Member::$mPageString}

							</td>

						 </tr>

					  </table>

                    </div>

                </div>

        </div> 

    </div>

    <div class="statics-footer"> Powered by phpWeChat V{__PHPWECHAT_VERSION__}{__PHPWECHAT_RELEASE__} © , Processed in {php echo microtime()-$PW['time_start'];} second(s) , {MySql::$mQuery} queries <a href="#">至顶端↑</a></div>

</body>

</html>