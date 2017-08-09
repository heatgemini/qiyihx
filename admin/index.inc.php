<?php
// +----------------------------------------------------------------------
// | phpWeChat 管理员首页入口文件 Last modified 2016/6/15 17:03
// +----------------------------------------------------------------------
// | Copyright (c) 2016-2017 phpWeChat http://www.qiyihx.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ITS.ME <616743670@qq.com> <http://www.qiyihx.com>
// +----------------------------------------------------------------------
use phpWeChat\PclZip;
use phpWeChat\Module;
use phpWeChat\MySql;

!defined('IN_MANAGE') && exit('Access Denied!');
$action=@return_edefualt(str_callback_w($_GET['action']),'index');

switch($action)
{
	case 'cache':
		$tables=MySql::getTables();
		
		for($i=1;$i<=CACHE_MYSQL_DB;$i++)
		{
			if(in_array(DB_PRE.'cache_'.$i,$tables))
			{
				MySql::query("TRUNCATE ".DB_PRE."cache_".$i);
			}
		}
		
		// 更新token缓存
		MySql::query("TRUNCATE `".DB_PRE."mem_cache`");
		operation_tips('缓存更新成功!');
		break;
	case 'index':
		include_once parse_admin_tlp('index');
		break;
	case 'main':
		include_once parse_admin_tlp('main');
		break;
	case 'update':
		if(isset($dosubmit) && $dosubmit)
		{
			$list=cache_read('update_'.$_userid.'.cache.php',PW_ROOT.'data/tmp/');

			if(!$list)
			{
				rm_dirs(PW_ROOT.'data/tmp/');
				mkdir(PW_ROOT.'data/tmp/');
				operation_tips('程序更新至最新版本!','?file=index&action=main');
			}

			$updatefile=array_shift($list);

			if(isset($updatefile['stored_filename']) && $updatefile['stored_filename'])
			{
				if(get_fileext($updatefile['filename'])=='sql')
				{
					$updatesqls=explode(';',file_get_contents(PW_ROOT.$updatefile['filename']));
					foreach($updatesqls as $updatesql)
					{
						$updatesql=str_replace('pw_',DB_PRE,trim($updatesql));
						if($updatesql)
						{
							MySql::query($updatesql);
						}
					}
				}
				else
				{
					make_dir(dirname($updatefile['stored_filename']));
					unlink(PW_ROOT.$updatefile['stored_filename']);
					rename(PW_ROOT.$updatefile['filename'],PW_ROOT.$updatefile['stored_filename']);
				}
			}
			cache_write('update_'.$_userid.'.cache.php',$list,PW_ROOT.'data/tmp/');
			operation_tips('文件'.$updatefile['stored_filename'].'已更新至最新版本，继续...','?file=index&action=update&dosubmit=1');

		}
		else
		{
			include_once PW_ROOT.'include/pclzip.class.php';

			$version=http_request('http://s.phpwechat.com/download/patch/version.txt');
			
			$version=trim($version);

			if(!$version)
			{
				operation_tips('升级异常，稍后再试！','','error');
			}

			//版本识别
			$_new_version=explode('.',$version);
			$_now_version=explode('.',PHPWECHAT_VERSION.PHPWECHAT_RELEASE);
			
			if($_new_version[0]<$_now_version[0])
			{
				operation_tips('当前程序已是最新版本！');
			}

			if($_new_version[0]==$_now_version[0] && $_new_version[1]<$_now_version[1])
			{
				operation_tips('当前程序已是最新版本！');
			}

			if($_new_version[0]>$_now_version[0])
			{	
				operation_tips('当前版本太老了，请手动更新！');
			}

			$_new_ver_ext=$_new_version[1].'.'.$_new_version[2];
			$_now_ver_ext=$_now_version[1].'.'.$_now_version[2];

			if($_new_ver_ext<=$_now_ver_ext)
			{
				operation_tips('当前程序'.$_new_ver_ext.'已是最新版本'.$_now_ver_ext.'！');
			}

			if($_new_ver_ext>$_now_ver_ext)
			{
				$version=$_new_version[0].'.'.sprintf("%01.1f",$_now_ver_ext+0.1);
				$debugfile='http://s.phpwechat.com/download/patch/'.$version.'.zip';
			}
			//exit($debugfile);	

			if(!is_writable(PW_ROOT))
			{
				operation_tips('请将 '.PW_ROOT.' 及子目录设为0777后再继续！','','error');
			}
			
			rm_dirs(PW_ROOT.'data/tmp/');
			mkdir(PW_ROOT.'data/tmp/');

			$data=http_request($debugfile);

			$modulezip='data/tmp/patch'.$version.'.zip';
			file_put_contents(PW_ROOT.$modulezip,$data);

			$zipObj = new PclZip(PW_ROOT.$modulezip);
			
			$list = $zipObj->extract(PCLZIP_OPT_PATH, "data/tmp/");       

			if ($list == 0) 
			{
				operation_tips('升级异常，稍后再试！','','error');
			}

			cache_write('update_'.$_userid.'.cache.php',$list,PW_ROOT.'data/tmp/');

			include_once parse_admin_tlp('update');
		}
		break;
	case 'menu':
		$menu='';
		$r=Module::getModuleByKey($modulekey);
		
		$configmenu=json_decode($r['configmenu'],true);

		if($configmenu)
		{
			$menu.='<li><a href="javascript:void(0);"><i class="icon-font">&#xe018;</i>配置选项</a><ul class="sub-menu">';

			foreach($configmenu as $action=>$name)
			{
				$name=explode(',',$name);
				if($r['folder'])
				{
					if($_roleid==-1 || (isset($_privileges[$r['folder']][$action]) && $_privileges[$r['folder']][$action]))
					{
						$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod='.$r['folder'].'&file=config&action='.$action.'" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe0'.$name[1].';</i>'.$name[0].'</a></li>';
					}
				}
				else
				{
					if($_roleid==-1 || (isset($_privileges['system'][$action])  && $_privileges['system'][$action]))
					{
						$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?file=config&action='.$action.'" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe0'.$name[1].';</i>'.$name[0].'</a></li>';
					}
				}
			}
			$menu.='</ul></li>';
		}
		
		if($modulekey=='system')
		{
			$menu.='<li><a href="javascript:void(0);" onclick="$(\'#sub-menu-module\').toggle();"><i class="icon-font">&#xe042;</i>功能模块</a><ul id="sub-menu-module" class="sub-menu">';

			if(in_array($_userid,explode(',',ADMIN_FOUNDERS)))
			{	
				$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?file=module&action=manage" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe009;</i>模块管理</a></li>';
				$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?file=module&action=diy" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe002;</i>自定义模块</a></li>';
			}
			
			$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?file=module&action=import" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe060;</i>导入模块</a></li>';
			$menu.='<li><a href="http://s.phpwechat.com/" target="iframe-wrap"><i class="icon-font">&#xe063;</i>应用商城</a></li>';
			$menu.='</ul></li>';

			if($_roleid==-1)
			{
				$menu.='<li><a href="javascript:void(0);" onclick="$(\'#sub-menu-db\').toggle();"><i class="icon-font">&#xe032;</i>数据库</a><ul class="sub-menu" id="sub-menu-db">';
				$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?file=db&action=export" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe010;</i>数据备份</a></li>';
				$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?file=db&action=import" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe011;</i>数据还原</a></li>';
				$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?file=db&action=repair" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe045;</i>优化修复</a></li>';
			}
			$menu.='</ul></li>';
		}

		if($modulekey=='5f04a16bb093201a')
		{
			$menu.='<li><a href="javascript:void(0);" onclick="$(\'#sub-menu-wechat\').toggle();"><i class="icon-font">&#xe058;</i>核心功能</a><ul class="sub-menu" id="sub-menu-wechat">';
			if($_roleid==-1 || isset($_privileges['wechat']['subscribereply']))
			{
				$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=wechat&file=core&action=subscribereply" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe026;</i>自动回复</a></li>';
			}
			if($_roleid==-1 || isset($_privileges['wechat']['masssend']))
			{
				$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=wechat&file=core&action=masssend" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe003;</i>群发消息</a></li>';
			}
			if($_roleid==-1 || isset($_privileges['wechat']['tmplmsg']))
			{
				$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=wechat&file=core&action=tmplmsg" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe004;</i>模板消息</a></li>';
			}
			if($_roleid==-1 || isset($_privileges['wechat']['ucenter']))
			{
				$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=wechat&file=core&action=ucenter" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe014;</i>粉丝营销</a></li>';
			}
			if($_roleid==-1 || isset($_privileges['wechat']['sceneqrcode']))
			{
				$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=wechat&file=core&action=sceneqrcode" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe064;</i>二维码营销</a></li>';
			}
			if($_roleid==-1 || isset($_privileges['wechat']['custommenu']))
			{
				$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=wechat&file=core&action=custommenu" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe062;</i>自定义菜单</a></li>';
			}
			if($_roleid==-1 || isset($_privileges['wechat']['youaskservice']))
			{
				$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=wechat&file=core&action=youaskservice" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe038;</i>人工多客服</a></li>';
			}
			$menu.='</ul></li>';
		}

		if($modulekey=='dcb26674c6706093')
		{
			$menu.='<li><a href="javascript:void(0);" onclick="$(\'#sub-menu-member\').toggle();"><i class="icon-font">&#xe058;</i>核心功能</a><ul class="sub-menu" id="sub-menu-member">';
			$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=member&file=config&action=config" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe017;</i>配置选项</a></li>';
			$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=member&file=member&action=level" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe031;</i>会员等级管理</a></li>';
			$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=member&file=member&action=member" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe014;</i>会员管理</a></li>';
			$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=member&file=member&action=login_log" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe060;</i>会员登录日志</a></li>';
			$menu.='</ul></li><li><a href="javascript:void(0);" onclick="$(\'#sub-menu-finance\').toggle();"><i class="icon-font">&#xe060;</i>财务日志</a><ul class="sub-menu" id="sub-menu-finance">';
			$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=member&file=member&action=credits_log" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe022;</i>会员积分日志</a></li>';
			$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod=member&file=member&action=amount_log" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe064;</i>会员余额日志</a></li>';
			$menu.='</ul></li>';
		}

		foreach(Module::menuModuleList($modulekey) as $i => $r)
		{
			if(!$r['disabled'] && ($_roleid==-1 || isset($_privileges[$r['folder']])))
			{
				$menu.='<li><a style="border-bottom:#e5e5e5 1px solid" href="javascript:void(0);" onclick="$(\'#sub-menu-'.$i.'\').toggle();"><i class="icon-font">&#xe036;</i>'.$r['name'].'</a><ul id="sub-menu-'.$i.'" class="sub-menu">';
				$_menu=json_decode($r['configmenu'],true);

				foreach ($_menu as $action => $name) 
				{
					$name=explode(',',$name);
					
					if($_roleid==-1 || (isset($_privileges[$r['folder']][$action]) && $_privileges[$r['folder']][$action]))
					{
						$menu.='<li><a href="'.PW_PATH.ADMIN_FILE.'?mod='.$r['folder'].'&file='.$r['folder'].'&action='.$action.'" onclick="setMenu($(this).parent().parent().attr(\'id\'));" target="iframe-wrap"><i class="icon-font">&#xe0'.$name[1].';</i>'.$name[0].'</a></li>';
					}
				}
				$menu.='</ul></li>';
			}
		}

		exit($menu);
		break;
}
?>