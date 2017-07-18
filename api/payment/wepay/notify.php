<?php
use phpWeChat\Order;

require_once substr(dirname(__FILE__),0,-18)."/include/common.inc.php";
require_once dirname(__FILE__)."/lib/WxPay.Api.php";
require_once dirname(__FILE__).'/lib/WxPay.Notify.php';
require_once dirname(__FILE__).'/log.php';

//初始化日志
$logHandler= new CLogFileHandler(dirname(__FILE__)."/logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}

		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		
		return true;
	}
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);

$xml = file_get_contents("php://input");
$xml = (array)simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

if($notify->NotifyProcess($xml, $msg))
{
	$orderinfo=Order::getOrder($xml["out_trade_no"]);
	//file_put_contents(PW_ROOT.'data/2.txt',var_export($orderinfo,true));
	if($orderinfo && $orderinfo['status']==-1)
	{
		$module=$orderinfo['mod'];
		$func=$module.ucfirst($orderinfo['action'].'PaySuccess');
		$func($xml["out_trade_no"]);
	}
}
?>
