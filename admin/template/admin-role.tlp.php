{php !defined('IN_MANAGE') && exit('Access Denied!');use Admin\Admin;use phpWeChat\Form;use phpWeChat\Module;use phpWeChat\MySql;}
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
	<script src="{__PW_PATH__}statics/jquery/jquery-1.12.2.min.js" language="javascript"></script>
    <script src="{__PW_PATH__}statics/reveal/jquery.reveal.js" language="javascript"></script>
	<script src="{__PW_PATH__}statics/core.js" language="javascript"></script>
    <script type="text/javascript" src="{__PW_PATH__}admin/template/js/libs/modernizr.min.js"></script>
    <script language="javascript" type="text/javascript">
		var PW_PATH='{__PW_PATH__}';
	</script>
    <style type="text/css">
		.btn-post{clear:both; margin:10px 10px; height:30px;}
		.a-btn-post{background:#44b549 ; color:#FFFFFF; font-size: 14px;font-weight: 400; display:block; width:125px; height:30px; line-height:30px; text-align:center;border-radius: 4px; float:left; margin-right:20px }
		.a-btn-post:hover{color:#FFFFFF; background:#339933}
	</style>
</head>
<body>
<div class="ifame-main-wrap">
      <div class="crumb-wrap">
          <div class="crumb-list"><i class="icon-font"></i><a href="{__PW_PATH__}{__ADMIN_FILE__}?file=index&action=main">管理首页</a><span class="crumb-step">&gt;</span><span class="crumb-name"><a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action={$action}">后台管理员</a></span></div>
      </div>
      <div class="result-wrap">
              <div class="admin-nav">
                <h2>后台管理员</h2>
                <div class="nav">
                    <a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action=manage">管理员管理</a>
                    {if $_roleid==-1}<a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action=add">添加管理员</a>{/if}
                    {if $_roleid==-1}<a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action=role" class="hover">角色管理</a>{/if}
                </div>
                <div class="admin-tips">
                   管理权权限由不同的管理角色决定，分配管理权限进进入<a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action=role">角色管理</a>进行操作。
                </div>
              </div>
              <form name="myform" id="myform" action="" method="post">
              <input type="hidden" value="edit" name="job" id="job">
              <div class="result-title">
                  <div class="result-list">
                      <a href="###" onClick="$('#myform').submit();"><i class="icon-font">&#xe065;</i>批量修改</a>
                  </div>
              </div>
              <div class="result-content">
                  <table class="result-tab" width="100%">
                      <tr>
                        <th class="tc" width="6%">ID</th>
                        <th width="6%">角色名称</th>
                        <th width="82%">角色权限</th>
                        <th width="5%">管理</th>
                    </tr>
					<tr>
                          <td class="tc">-1</td>
                          <td>
                          超级管理员
                          </td>
						  <td>全部权限</td>
                           <td>
                             <font style="color:#999999"> 删除 </font>                        
                           </td>
                    	</tr>
                      {loop $data $r}
                      {php $r=(array)$r;$privs=json_decode($r['privileges'],true);}
                      <tr>
                          <td class="tc">{$r['roleid']}</td>
                          <td>
                          <input type="hidden" value="{$r['roleid']}" name="roleids[{$r['roleid']}]">
                          <input type="text" class="common-text" name="names[{$r['roleid']}]" value="{$r['name']}" size="16" />
                          </td>
						  <td>
                         	 	<table width="99%">
                                 	{loop Module::moduleList(0) $r2}
                                    {php $configmenu=json_decode($r2['configmenu'],true);}
                                    {if $configmenu}
                                    <tr>
                                    <td style="text-align:left">{$r2['name']}：</td>
                                    {loop $configmenu $_menukey   $_menuname}
                                    {php $_menuname=explode(',',$_menuname);$r2['folder']=$r2['folder']?$r2['folder']:'system';}
                                    <td style="text-align:left"><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[{$r['roleid']}][{$r2['folder']}][{$_menukey}]" {if $privs[$r2['folder']][$_menukey]}checked{/if}>{$_menuname[0]}&nbsp;&nbsp;</label></td>
                                    {/loop}
									{if $r2['folder']=='wechat'}
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" value="1" {if $privs['wechat']['subscribereply']}checked{/if} name="privileges[{$r['roleid']}][wechat][subscribereply]" >关注自动回复&nbsp;&nbsp;</label></td>
									</tr>
									<tr>
									<td></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['autoreply']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][autoreply]" >消息自动回复&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['helpreply']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][helpreply]" >关键词自动回复&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['masssend']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][masssend]" >发送群发消息&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['masssend_list']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][masssend_list]" >群发消息管理&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['tmplmsg']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][tmplmsg]" >模板消息&nbsp;&nbsp;</label></td>
									</tr>
									<tr>
									<td></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['ucenter']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][ucenter]" >粉丝营销&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['load_fans']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][load_fans]" >同步粉丝&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['groups']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][groups]" >粉丝分组&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['load_groups']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][load_groups]" >同步粉丝分组&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['sceneqrcode']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][sceneqrcode]" >二维码营销&nbsp;&nbsp;</label></td>
									</tr>
									<tr>
									<td></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['custommenu']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][custommenu]" >自定义菜单&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['create_menu']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][create_menu]" >生成自定义菜单&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['youaskservice']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][youaskservice]" >人工多客服&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['youaskservice_onlie']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][youaskservice_onlie]" >在线客服&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['youaskservice_add']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][youaskservice_add]" >添加客服&nbsp;&nbsp;</label></td>
									<td style="text-align:left"><label><input type="checkbox" class="common-checkbox" {if $privs['wechat']['youaskservice_synchronism']}checked{/if} value="1" name="privileges[{$r['roleid']}][wechat][youaskservice_synchronism]" >同步客服&nbsp;&nbsp;</label></td>
									{/if}
                                    </tr>
                                    {loop Module::moduleList($r2['key']) $_r}
                                    {php $_configmenu=json_decode($_r['configmenu'],true);}
                                    {if $_configmenu}
                                    <tr>
                                    <td style="text-align:left"><font style="color:#CCCCCC; font-size:12px">|—</font> {$_r['name']}：</td>
                                    {loop $_configmenu $_menu2key   $_menu2name}
                                    {php $_menu2name=explode(',',$_menu2name);}
                                    <td style="text-align:left"><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[{$r['roleid']}][{$_r['folder']}][{$_menu2key}]"  {if $privs[$_r['folder']][$_menu2key]}checked{/if}>{$_menu2name[0]}&nbsp;&nbsp;</label></td>
                                    {/loop}
                                    </tr>
                                    {/if}
                                    {/loop}
                                    {/if}
                                    {/loop}
                                </table>
                          </td>
                           <td width="12%">
                              {if $_roleid==-1 && $r['userid']!=$_userid}
                              <a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action=roleid_delete&roleid={$r['roleid']}">删除</a>
                              {else}
                              <font style="color:#999999"> 删除 </font> 
                              {/if}                          
                          </td>
                    </tr>
                     {/loop}
                  </table>
              </div>
              </form>
              <form action="" method="post" name="mysubmitform" id="mysubmitform" enctype="multipart/form-data">
            	<input type="hidden" value="1" name="dosubmit">
                <div class="config-items" style="margin-top:8px">
                    <div class="config-title">
                        <h1><a href="{__PW_PATH__}{__ADMIN_FILE__}?mod={$mod}&file={$file}&action={$action}"><i class="icon-font">&#xe026;</i>添加角色</a></h1>
                    </div>
                    <div class="result-content">
                        <table width="100%" class="insert-tab">
                            <tbody>
                            	<tr class="formtr">
                                    <th class="formth" width="20%"><i class="require-red">*</i>角色名称：</th>
                                    <td class="formtd">
                                 	<input type="text" class="common-text" name="info[name]" size="36" />
                                    </td>
                                </tr>
								<tr class="formtr">
                                    <th class="formth"><i class="require-red">*</i>角色权限：</th>
                                    <td class="formtd">
                                    <table width="85%">
                                 	{loop Module::moduleList(0) $r}
                                    {php $configmenu=json_decode($r['configmenu'],true);}
                                    {if $configmenu}
                                    <tr>
                                    <td>{$r['name']}：</td>
                                    {loop $configmenu $_menukey   $_menuname}
                                    {php $_menuname=explode(',',$_menuname);$r['folder']=$r['folder']?$r['folder']:'system';}
                                    <td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[{$r['folder']}][{$_menukey}]" >{$_menuname[0]}&nbsp;&nbsp;</label></td>
                                    {/loop}
									{if $r['folder']=='wechat'}
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][subscribereply]" >关注自动回复&nbsp;&nbsp;</label></td>
									</tr>
									<tr>
									<td></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][autoreply]" >消息自动回复&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][helpreply]" >关键词自动回复&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][masssend]" >发送群发消息&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][masssend_list]" >群发消息管理&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][tmplmsg]" >模板消息&nbsp;&nbsp;</label></td>
									</tr>
									<tr>
									<td></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][ucenter]" >粉丝营销&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][load_fans]" >同步粉丝&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][groups]" >粉丝分组&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][load_groups]" >同步粉丝分组&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][sceneqrcode]" >二维码营销&nbsp;&nbsp;</label></td>
									</tr>
									<tr>
									<td></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][custommenu]" >自定义菜单&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][create_menu]" >生成自定义菜单&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][youaskservice]" >人工多客服&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][youaskservice_onlie]" >在线客服&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][youaskservice_add]" >添加客服&nbsp;&nbsp;</label></td>
									<td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[wechat][youaskservice_synchronism]" >同步客服&nbsp;&nbsp;</label></td>
									{/if}
                                    </tr>
                                    {loop Module::moduleList($r['key']) $_r}
                                    {php $_configmenu=json_decode($_r['configmenu'],true);}
                                    {if $_configmenu}
                                    <tr>
                                    <td><font style="color:#CCCCCC; font-size:12px">|—</font> {$_r['name']}：</td>
                                    {loop $_configmenu $_menu2key   $_menu2name}
                                    {php $_menu2name=explode(',',$_menu2name);}
                                    <td><label><input type="checkbox" class="common-checkbox" value="1" name="privileges[{$_r['folder']}][{$_menu2key}]" >{$_menu2name[0]}&nbsp;&nbsp;</label></td>
                                    {/loop}
                                    </tr>
                                    {/if}
                                    {/loop}
                                    {/if}
                                    {/loop}
                                    </table>
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