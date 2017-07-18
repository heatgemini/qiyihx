<?php
	use phpWeChat\Module;

	define('IN_APP',true);

	if(!file_exists(dirname(__FILE__).'/data/phpwechat.lock'))
	{
		header('location:install/index.php');
		exit();
	}
	
	
	require dirname(__FILE__).'/include/common.inc.php';

	$_GET=array_map('str_callback_w',$_GET);

	$mod=@return_edefualt($_GET['m'],'pc');
	$action=@return_edefualt($_GET['a'],'index');

	define('MOD',$mod);
	define('ACTION',$action);

	//定义当前浏览是PC还是移动端的常量
	define('ISH5',is_mobile()?1:0); 

	$modinfo=Module::getModule($mod);

	if(!$modinfo['parentkey'])
	{	
		//获取前端视图路径
		if($modinfo['ispch5'] && ISH5)
		{
			if(isset($PW[$mod.'_h5_template']) && $PW[$mod.'_h5_template'])
			{
				define('TLP','addons/'.$modinfo['folder'].'/template/'.$PW[$mod.'_h5_template'].'/');
			}
			else
			{
				define('TLP','addons/'.$modinfo['folder'].'/template/h5_default/');
			}
		}
		else
		{
			if(isset($PW[$mod.'_template']) && $PW[$mod.'_template'])
			{
				define('TLP','addons/'.$modinfo['folder'].'/template/'.$PW[$mod.'_template'].'/');
			}
			else
			{
				define('TLP','addons/'.$modinfo['folder'].'/template/default/');
			}
		}
		
		//获取前端控制器文件
		$controller_file=PW_ROOT.'addons/'.$modinfo['folder'].'/index.php';

		if($modinfo['ispch5'] && ISH5)
		{
			$controller_file=PW_ROOT.'addons/'.$modinfo['folder'].'/h5_index.php';
		}

		if(is_file($controller_file))
		{
			include_once $controller_file;
		}

		//获取前端视图文件
		include template($action);
	}
	else
	{
		//获取前端控制器文件
		$controller_file='addons/'.Module::getModuleByKey($modinfo['parentkey'],'folder').'/addons/'.$mod.'/index.php';

		if($modinfo['ispch5'] && ISH5)
		{
			$controller_file='addons/'.Module::getModuleByKey($modinfo['parentkey'],'folder').'/addons/'.$mod.'/h5_index.php';
		}

		if($modinfo['ispch5'] && ISH5)
		{
			if(isset($PW[$mod.'_h5_template']) && $PW[$mod.'_h5_template'])
			{
				define('TLP','addons/'.Module::getModuleByKey($modinfo['parentkey'],'folder').'/addons/'.$mod.'/template/'.$PW[$mod.'_h5_template'].'/');
			}
			else
			{
				define('TLP','addons/'.Module::getModuleByKey($modinfo['parentkey'],'folder').'/addons/'.$mod.'/template/h5_default/');
			}
		}
		else
		{
			if(isset($PW[$mod.'_template']) && $PW[$mod.'_template'])
			{
				define('TLP','addons/'.Module::getModuleByKey($modinfo['parentkey'],'folder').'/addons/'.$mod.'/template/'.$PW[$mod.'_template'].'/');
			}
			else
			{
				define('TLP','addons/'.Module::getModuleByKey($modinfo['parentkey'],'folder').'/addons/'.$mod.'/template/default/');
			}
		}
		
		if(is_file(PW_ROOT.$controller_file))
		{
			include_once PW_ROOT.$controller_file;
		}
		else
		{	
			fatal_error('File '.PW_ROOT.$controller_file.' not exists!',1001);
		}

		include template($action);
	}
?>