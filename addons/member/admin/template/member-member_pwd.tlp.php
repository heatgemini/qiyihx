{php !defined('IN_MANAGE') && exit('Access Denied!');use phpWeChat\Form;use phpWeChat\Member;use phpWeChat\MySql;}

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

	<script src="{__PW_PATH__}statics/jquery/jquery-2.1.3.min.js" language="javascript"></script>

    <script src="{__PW_PATH__}statics/reveal/jquery.reveal.js" language="javascript"></script>

	<script src="{__PW_PATH__}statics/core.js" language="javascript"></script>

    <script type="text/javascript" src="{__PW_PATH__}admin/template/js/libs/modernizr.min.js"></script>

    <script language="javascript" type="text/javascript">

	$(document).ready(function(){

		$('#parentid').val({$data['parentid']});
		
		$('#showpwd').click(function(){
			
			if($('#newpassword').attr('type')=='password')
			{
				$('#newpassword').attr('Type','text');
				$('#showpwd').text('隐藏密码');
			}
			else
			{
				$('#newpassword').attr('Type','password');
				$('#showpwd').text('显示密码');
			}
		});

	});

	</script>

</head>

<body>

<div class="ifame-main-wrap">

      <div class="crumb-wrap">

          <div class="crumb-list"><i class="icon-font"></i><a href="{__PW_PATH__}{__ADMIN_FILE__}?file=index&action=main">管理首页</a><span class="crumb-step">&gt;</span><span class="crumb-name"><a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action={$action}">重置密码</a></span></div>

      </div>

      <div class="result-wrap">
		   <form action="" method="post" name="mysubmitform" id="mysubmitform" enctype="multipart/form-data">

            	<input type="hidden" value="1" name="dosubmit">
				<input type="hidden" value="{$userid}" name="userid">
                <div class="config-items" style="margin-top:8px">

                    <div class="admin-nav">

                        <h2>会员管理</h2>

                        <div class="nav">
							<a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action=member">会员管理</a>
                            <a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action={$action}&userid={$userid}" class="hover">重置密码</a>
                        </div>

                    </div>

                    <div class="result-content">

                        <table width="100%" class="insert-tab">

                            <tbody>

                            	<tr class="formtr">

                                    <th class="formth"><i class="require-red">*</i>会员名称：</th>

                                    <td class="formtd">

                                 	{$data['username']}

                                    </td>

                                </tr>

								<tr class="formtr">

                                    <th class="formth"><i class="require-red">*</i>会员密码（重置）：</th>

                                    <td class="formtd">

                                 	<input type="password" class="common-text" name="newpassword" id="newpassword" size="36" />
									<a href="javascript:void(0);" id="showpwd">显示密码</a>
									<span style="font-size:12px; color:#FF3300"><br>如果留空，则不重置密码</span>
                                    </td>

                                </tr>
								
                                <tr class="formtr">

                                    <th class="formth"></th>

                                    <td class="formtd">

                                        <input type="button" onClick="doSubmit('mysubmitform','')" value="提 交" class="submit-button">

                                        <input type="button" value="返 回" onClick="history.go(-1)" class="reset-button">

                                    </td>

                                </tr>

                            </tbody></table>

                    </div>

                </div>

            </form>

      </div>

  </div>

    <div class="statics-footer"> Powered by phpWeChat V{__PHPWECHAT_VERSION__}{__PHPWECHAT_RELEASE__} © , Processed in {php echo microtime()-$PW['time_start'];} second(s) , {MySql::$mQuery} queries <a href="#">至顶端↑</a></div>

</body>

</html>