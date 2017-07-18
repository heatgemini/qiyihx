<?php
	use phpWeChat\Module;
	use phpWeChat\Member;
	use phpWeChat\Ip;

	!defined('IN_APP') && exit('Access Denied!');
	
	$uc_module_list=Module::ucModuleList(array(1,3));

	if($_userid)
	{
		$_myaddress=Member::myAddressList($_userid) ;//我的地址数组
	}

	switch($action)
	{
		/**
			*微信端
		*/
		case 'login': //2016/6/22
			$redirect=$redirect?$redirect:U(MOD,'i');
			set_cookie('redirect',$redirect);
			
			if($_userid)
			{
				header("location:".$redirect);
				exit();
			}

			if(isset($dosubmit))
			{
				$telephone=trim($telephone);
				$password=trim($password);

				if(!is_telephone($telephone))
				{
					exit('telephone');
				}

				$mem=Member::getUserByTelephone($telephone);
				if(!$mem)
				{
					exit('telephone');
				}

				if($mem['userpwd']!=md5($password))
				{
					exit('password');
				}

				set_cookie('userid',$mem['userid']);
				
				//更新登录信息
				$logindata=array();
				$logindata['logintime']=CLIENT_TIME;
				$logindata['loginip']=Ip::getIp();
				if(!$mem['openid'] && $_SESSION['openid'])
				{
					$logindata['openid']=$_SESSION['openid'];
				}
				Member::memUpdate($mem['userid'],$logindata);

				//更新会员登录日志
				$loginlog=array();
				$loginlog['userid']=$mem['userid'];
				$loginlog['logintime']=CLIENT_TIME;
				$loginlog['loginip']=Ip::getIp();
				$loginlog['loginenv']='移动端登录 浏览器：'.Ip::getBrowser();
				Member::loginLog($loginlog);
				exit('success');
			}
			break;
		case 'register': //2016/6/22
			$redirect=$redirect?$redirect:U(MOD,'i');
			set_cookie('redirect',$redirect);
			
			if(isset($dosubmit) && $dosubmit)
			{
				if(!trim($telephone) || !is_telephone($telephone))
				{
					exit('telephone');
				}

				if(intval($PW['member_register_checktype']))
				{
					if(strlen($smscode)!=4 || $_SESSION['smscode']!=trim($smscode))
					{
						exit('smscode');
					}
				}
				else
				{
					if($smscode!=strtolower($_SESSION['captcha_code']))
					{
						exit('smscode');
					}
				}
				

				if(strlen($userpwd)<6)
				{
					exit('userpwd');
				}

				if($userpwd!=$reuserpwd)
				{
					exit('reuserpwd');
				}

				$mem=Member::getUserByTelephone($telephone);
				if($mem)
				{
					exit('-2');
				}

				$info=array();
				$info['username']=$telephone;
				$info['telephone']=$telephone;
				$info['userpwd']=$userpwd;
				$info['openid']=$_SESSION['openid'];
				
				$_userid=Member::register($info);

				if($_userid>0)
				{
					set_cookie('userid',$_userid);
					
					exit('success');
				}
				else
				{
					echo($_userid);exit();
				}
			}
			break;
		case 'getpwd': //2016/6/22
			if(isset($dosubmit) && $dosubmit)
			{
				if(!trim($telephone) || !is_telephone($telephone))
				{
					exit('telephone');
				}

				if(strlen($smscode)!=4 || $_SESSION['smscode']!=trim($smscode))
				{
					exit('smscode');
				}

				if(strlen($userpwd)<6)
				{
					exit('userpwd');
				}

				if($userpwd!=$reuserpwd)
				{
					exit('reuserpwd');
				}

				$info=array();
				$info['username']=$telephone;
				$info['telephone']=$telephone;
				$info['userpwd']=$userpwd;
				$info['openid']=$_SESSION['openid'];
				
				$_userid=Member::getUserByTelephone($telephone,'userid');

				if($_userid)
				{
					Member::resetPassword($_userid,$userpwd);
					exit('success');
				}
				else
				{
					echo(-1);
					exit();
				}
			}
			break;
		case 'logout':
			$redirect=$redirect?$redirect:U(MOD,'login');
			set_cookie('userid',0);

			header("location:$redirect");
			exit();
			break;
		/**
			*已登录状态会员中心操作
		*/
		case 'i': //会员首页
			if(!$_userid)
			{
				header("location:".U(MOD,'login'));
				exit();
			}

			break;
		case 'account': //修改密码
			if(!$_userid)
			{
				header("location:".U(MOD,'login'));
				exit();
			}

			if($dosubmit)
			{
				$password=trim($password);
				$newpassword=trim($newpassword);

				$data=array();
				$data['errcode']=0;
				$data['errstr']='密码修改成功';

				//对于微信端登录，无需输入旧密码
				if(!$_SESSION['openid'] && md5($password)!=$PW['memberlogin']['userpwd'])
				{
					$data['errcode']=1001;
					$data['errstr']='密码修改失败，旧密码不正确！';

					exit(json_encode($data));
				}

				if(strlen($newpassword)<6 || strlen($newpassword)>18)
				{
					$data['errcode']=1002;
					$data['errstr']='密码要求由6~18位字符组成';

					exit(json_encode($data));
				}

				if(md5($newpassword)!=md5($repassword))
				{
					$data['errcode']=1003;
					$data['errstr']='两次密码输入不一致';

					exit(json_encode($data));
				}

				Member::memUpdate($_userid,array('userpwd'=>md5($newpassword)));
				exit(json_encode($data));
			}
			break;
		case 'mycredits': //我的积分
			if(!$_userid)
			{
				header("location:".U(MOD,'login'));
				exit();
			}

			$data=Member::creditsLogList($_userid,6);

			if($isajax)
			{
				$result=array();

				if($page>Member::$mTotalPage)
				{
					$result['errcode']=-1;
					$result['errstr']='暂无更多数据';
					$result['list']=array();
					exit(json_encode($result));
				}

				$result['errcode']=0;
				$result['errstr']='数据加载成功';
				$result['list']=$data;
				exit(json_encode($result));
			}
			break;
		case 'myamount': //我的余额
			if(!$_userid)
			{
				header("location:".U(MOD,'login'));
				exit();
			}

			$data=Member::amountLogList($_userid,6);

			if($isajax)
			{
				$result=array();

				if($page>Member::$mTotalPage)
				{
					$result['errcode']=-1;
					$result['errstr']='暂无更多数据';
					$result['list']=array();
					exit(json_encode($result));
				}

				$result['errcode']=0;
				$result['errstr']='数据加载成功';
				$result['list']=$data;
				exit(json_encode($result));
			}
			break;
		case 'mylogin': //我的登录日志
			if(!$_userid)
			{
				header("location:".U(MOD,'login'));
				exit();
			}

			$data=Member::loginLogList($_userid,6);

			if($isajax)
			{
				$result=array();

				if($page>Member::$mTotalPage)
				{
					$result['errcode']=-1;
					$result['errstr']='暂无更多数据';
					$result['list']=array();
					exit(json_encode($result));
				}

				foreach ($data as $key => $r) 
				{
					$data[$key]['logintime']=date('m-d H:i',$r['logintime']);
				}

				$result['errcode']=0;
				$result['errstr']='数据加载成功';
				$result['list']=$data;
				exit(json_encode($result));
			}

			break;
		case 'myaddress': //我的地址
			if(!$_userid)
			{
				header("location:".U(MOD,'login'));
				exit();
			}

			$id=intval($id);

			$data=Member::myAddressList($_userid);

			if($id)
			{
				$modifydata=Member::getAddress($id);
			}
			break;
		case 'myaddress_post':
			if(!$_userid)
			{
				header("location:".U(MOD,'login'));
				exit();
			}

			$id=intval($id);
			if($id)
			{
				$modifydata=Member::getAddress($id);
			}
			break;
		case 'myaddress_save':
			$data=array();
			$data['errcode']=0;
			$data['errstr']='地址保存成功';

			if(!$_userid)
			{
				$data['errcode']=2001;
				$data['errstr']='请先登录';
				exit(json_encode($data));
			}

			$info=pw_trim($info);

			if(!$info['realname'])
			{
				$data['errcode']=2002;
				$data['errstr']='收件人不能为空';

				exit(json_encode($data));
			}

			if(!$info['telephone'] || !is_telephone($info['telephone']))
			{
				$data['errcode']=2003;
				$data['errstr']='手机号码格式不正确';

				exit(json_encode($data));
			}

			if(!$info['address'])
			{
				$data['errcode']=2004;
				$data['errstr']='请输入详细地址';

				exit(json_encode($data));
			}

			$info['userid']=$_userid;

			if($id)
			{
				$modifydata=Member::getAddress($id);
				if($modifydata['userid']!=$_userid)
				{
					$data['errcode']=2005;
					$data['errstr']='非法请求';

					exit(json_encode($data));
				}

				Member::addressEdit($info,$id);
			}
			else
			{
				Member::addressAdd($info);
			}
			
			exit(json_encode($data));
			break;
		case 'myaddress_delete':
			$data=array();
			$data['errcode']=0;
			$data['errstr']='地址删除成功';

			if(!$_userid)
			{
				$data['errcode']=3001;
				$data['errstr']='请先登录';
				exit(json_encode($data));
			}

			$id=intval($id);
			$address_data=Member::getAddress($id);

			if($address_data['userid']!=$_userid)
			{
				$data['errcode']=3002;
				$data['errstr']='非法请求';
				exit(json_encode($data));
			}

			if($address_data['default'])
			{
				$data['errcode']=3004;
				$data['errstr']='默认地址不能删除';
				exit(json_encode($data));
			}

			Member::addressDelete($id);
			exit(json_encode($data));
			break;
		case 'myaddress_default':
			$data=array();
			$data['errcode']=0;
			$data['errstr']='操作成功';

			if(!$_userid)
			{
				$data['errcode']=4001;
				$data['errstr']='请先登录';
				exit(json_encode($data));
			}

			$id=intval($id);
			$address_data=Member::getAddress($id);

			if($address_data['userid']!=$_userid)
			{
				$data['errcode']=4002;
				$data['errstr']='非法请求';
				exit(json_encode($data));
			}

			if(!$address_data['default'])
			{
				Member::setMyDefaultAddress($id,$_userid);
			}
			
			exit(json_encode($data));
			break;
		default:
			wealert('Access Denied!','err');
			break;
	}
?>