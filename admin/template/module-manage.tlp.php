{php !defined('IN_MANAGE') && exit('Access Denied!');use phpWeChat\Form;use phpWeChat\Module;use phpWeChat\MySql;}

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
	
	<script type="text/javascript" src="{__PW_PATH__}statics/ZeroClipboard/ZeroClipboard.js"></script> 

    <script src="{__PW_PATH__}statics/reveal/jquery.reveal.js" language="javascript"></script>

	<script src="{__PW_PATH__}statics/core.js" language="javascript"></script>

    <script type="text/javascript" src="{__PW_PATH__}admin/template/js/libs/modernizr.min.js"></script>

    

</head>

<body>

<div class="ifame-main-wrap">

      <div class="crumb-wrap">

          <div class="crumb-list"><i class="icon-font"></i><a href="{__PW_PATH__}{__ADMIN_FILE__}?file=index&action=main">管理首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">模块管理</span></div>

      </div>

      <div class="result-wrap">

          <form name="myform" id="myform" action="" method="post">

              <input type="hidden" value="delete" name="job" id="job">

              <div class="result-title">

                  <div class="result-list">

                      <a href="{__PW_PATH__}{__ADMIN_FILE__}?mod=&file={$file}&action=diy"><i class="icon-font">&#xe002;</i>自定义模块</a>

                      <a href="###" onClick="if(isCheckboxChecked()){$('#job').val('setoderby');$('#myform').submit();}else{alert('请选择要'+$(this).text()+' 的项目！')}"><i class="icon-font">&#xe062;</i>更新排序</a>

                      <a href="###" onClick="if(isCheckboxChecked()){$('#job').val('setundisabled');$('#myform').submit();}else{alert('请选择要'+$(this).text()+' 的项目！')}"><i class="icon-font">&#xe068;</i>批量启用</a>

                      <a href="###" onClick="if(isCheckboxChecked()){$('#job').val('setdisabled');$('#myform').submit();}else{alert('请选择要'+$(this).text()+' 的项目！')}"><i class="icon-font">&#xe069;</i>批量禁用</a>

                      {if $parentkey}<a href="###" onClick="if(!confirm('确定要卸载此模块吗？')){return false;}else{if(isCheckboxChecked()){$('#job').val('uninstall');$('#myform').submit();}else{alert('请选择要'+$(this).text()+' 的项目！')}}"><i class="icon-font">&#xe061;</i>批量卸载模块</a>{/if}

                  </div>

              </div>

              <div class="result-content">

                  <table class="result-tab" width="100%">

                      <tr>

                          <th class="tc" width="5%"><input id="checkAll" class="common-checkbox" title="全选/反选" type="checkbox"></th>

                          <th width="15%">Key</th>

                          <th width="5%">排序</th>

                          <th width="11%">名称</th>

                          <th width="24%">路径</th>

                          <th width="10%">父模块</th>

                          <th width="5%">状态</th>

                          <th width="30%">操作</th>

                      </tr>

                      {loop Module::moduleList($parentkey) $r}

                      {if $r['folder']}

                      <tr>

                          <td class="tc"><input name="keys[{$r['key']}]" la="checkbox" class="common-checkbox" value="{$r['key']}" type="checkbox"></td>

                          <td>{strtoupper($r['key'])}</td>

                          <td title="{$r['orderby']}"><input class="common-text" size="2" style="text-align:center" value="{$r['orderby']}" name="orderbys[{$r['key']}]"></td>

                          <td style="line-height:2em">{$r['name']}
						  {if $parentkey}<br><font style="font-size:12px">{Module::version($r['key'])}</font>{/if}
						  </td>

						  

                          <td style="font-size:12px">{php echo ($parentkey?'/addons/'.Module::getModuleByKey($parentkey,'folder').'/addons/':'/addons/').$r['folder'];}</td>

                          <td>{php echo $r['parentkey']?Module::getModuleByKey($r['parentkey'],'name'):'一级模块';}</td>

                          <td>{php echo $r['disabled']?'<font style="color:#ff3300">已禁用</font>':'<font style="color:#44b549">正常</font>';}</td>

                          <td>

                          	  {if !$parentkey}<a href="{__PW_PATH__}{__ADMIN_FILE__}?mod=&file={$file}&action={$action}&parentkey={$r['key']}">管理子模块 [<span style="font-weight:bold; color:#FF3300">{Module::getChindrenCounts($r['key'])}</span>]</a>

                              &nbsp;&nbsp;&nbsp;

							  {else}
							  <a href="{__PW_PATH__}{__ADMIN_FILE__}?mod=&file={$file}&action=set&modulekey={$r['key']}">配置</a>

							   &nbsp;|&nbsp;
 							  <a href="{__PW_PATH__}{__ADMIN_FILE__}?mod=&file={$file}&action=tables&modulekey={$r['key']}">关联数据表</a>

							   &nbsp;|&nbsp;

							  <a onClick="if(!confirm('确定要导出此模块吗？')){return false;}" href="{__PW_PATH__}{__ADMIN_FILE__}?mod=&file={$file}&action=export&modulekey={$r['key']}">导出</a>
                 &nbsp;|&nbsp;

							  <a onClick="if(!confirm('确定要卸载此模块吗？')){return false;}" href="{__PW_PATH__}{__ADMIN_FILE__}?mod=&file={$file}&action={$action}&job=uninstall&keys={$r['key']}">卸载</a>
				&nbsp;|&nbsp;

							  <a href="http://s.phpwechat.com/index.php?action=patch&domain={urlencode(get_server_name())}&module={$r['key']}&version={strtolower(Module::version($r['key']))}" target="_blank" >补丁包</a>
							<br>
							<input type="hidden"  value="{format_url(U($r['folder']))}" id="fe_text_{$r['folder']}">
							<a href="#" id="clip_{$r['folder']}">复制模块链接URL</a>
							<script language="javascript" type="text/javascript"> 
									var clip{$r['folder']} = new ZeroClipboard.Client(); // 新建一个对象 
									clip{$r['folder']}.setHandCursor( true ); // 设置鼠标为手型 
									clip{$r['folder']}.setText($('#fe_text_{$r['folder']}').val()); // 设置要复制的文本。 
									// 注册一个 button，参数为 id。点击这个 button 就会复制。 
									//这个 button 不一定要求是一个 input 按钮，也可以是其他 DOM 元素。 
									clip{$r['folder']}.glue("clip_{$r['folder']}"); // 和上一句位置不可调换 
									clip{$r['folder']}.addEventListener( "complete", function(){ 
									alert("模块URL复制成功，您可以直接粘贴到自定义菜单或者其他地方！"); 
									}); 
							</script> 
                               {/if}

                          </td>

                      </tr>

                     {/if}

                     {/loop}

                  </table>

              </div>

          </form>

      </div>

  </div>

    <div class="statics-footer"> Powered by phpWeChat V{__PHPWECHAT_VERSION__}{__PHPWECHAT_RELEASE__} © , Processed in {php echo microtime()-$PW['time_start'];} second(s) , {MySql::$mQuery} queries <a href="#">至顶端↑</a></div>

</body>

</html>