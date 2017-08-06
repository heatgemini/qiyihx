<?php


/**
 * 
 * 接口访问类，包含所有微信支付API列表的封装，类中方法为static方法，
 * 每个接口有默认超时时间（除提交被扫支付为10s，上报超时时间为1s外，其他均为6s）
 * @author zhang_qing
 *
 */
class HttpUtil
{
	

	function sendGet($url){  
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}
	
	function sendPost($url,$post){  
        $options = array(  
	        CURLOPT_RETURNTRANSFER => true,  
	        CURLOPT_HEADER         => false,  
	        CURLOPT_POST           => true,  
	        CURLOPT_POSTFIELDS     => $post,  
	    );  
	  
	    $ch = curl_init($url);  
	    curl_setopt_array($ch, $options);  
	    $result = curl_exec($ch);  
	    curl_close($ch);  
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	function sendPostString($url,$post){  
        $options = array(  
	        CURLOPT_RETURNTRANSFER => false,  
	        CURLOPT_HEADER         => false,  
	        CURLOPT_POST           => true,  
	        CURLOPT_POSTFIELDS     => $post
	    );  
	  
	    $ch = curl_init($url);  
	    curl_setopt_array($ch, $options);  
	    $result = curl_exec($ch);  
	    curl_close($ch);  
		return $result;
	}


}

