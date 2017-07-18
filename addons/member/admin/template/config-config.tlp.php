{php !defined('IN_MANAGE') && exit('Access Denied!');use phpWeChat\MySql;}

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

            <div class="crumb-list"><i class="icon-font"></i><a href="{__PW_PATH__}{__ADMIN_FILE__}?file=index&action=main">管理首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">配置选项</span></div>

        </div>

        <div class="result-wrap">

            <form action="" method="post" name="mysubmitform" id="mysubmitform" enctype="multipart/form-data">

            	<input type="hidden" value="1" name="dosubmit">

                <div class="config-items">

                    <div class="config-title">

                        <h1><i class="icon-font">&#xe00a;</i>会员系统配置</h1>

                    </div>

                    <div class="result-content">

                        <table width="100%" class="insert-tab">

                            <tbody>

                                <tr class="formtr">

                                    <th class="formth" width="20%"><i class="require-red">*</i>开启会员注册：</th>

                                    <td class="formtd">

                                     <label><input type="radio" name="info[member_register_on]" class="common-radio" {if $PW['member_register_on']}checked{/if} value="1">开启</label>

                                    &nbsp; &nbsp; &nbsp; &nbsp;

                                     <label><input type="radio" name="info[member_register_on]" class="common-radio" {if $PW['member_register_on']==0}checked{/if} value="0">关闭</label>

									</td>

                                </tr>
								
								<tr class="formtr">

                                    <th class="formth" width="20%"><i class="require-red">*</i>会员注册验证码类型：</th>

                                    <td class="formtd">

                                     <label><input type="radio" name="info[member_register_checktype]" class="common-radio" {if $PW['member_register_checktype']}checked{/if} value="1">短信验证码</label>

                                    &nbsp; &nbsp; &nbsp; &nbsp;

                                     <label><input type="radio" name="info[member_register_checktype]" class="common-radio" {if $PW['member_register_checktype']==0}checked{/if} value="0">图片验证码</label>

									</td>

                                </tr>

                                <tr class="formtr">

                                    <th class="formth"><i class="require-red">*</i>开启会员登录：</th>

                                    <td class="formtd">

                                     <label><input type="radio" name="info[member_login_on]" class="common-radio" {if $PW['member_login_on']}checked{/if} value="1">开启</label>

                                     &nbsp; &nbsp; &nbsp; &nbsp;

                                     <label><input type="radio" name="info[member_login_on]" class="common-radio" {if $PW['member_login_on']==0}checked{/if} value="0">关闭</label>

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