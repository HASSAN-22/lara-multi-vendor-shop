<?php


namespace App\Auxiliary\Bank;

use App\Auxiliary\Bank\Gateway;
use Exception;

class Melat implements Gateway{
	
	private static $URL = "https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl";

	/**
	*
	* Send the transaction to the bank portal 
	*
	* @param array $gatewayInfo
	*
	* @return mixed
	*/ 
	public static function request(array $gatewayInfo):mixed{
		$parameters = [
			'terminalId' 		=> $gatewayInfo["terminalId"],
			'userName' 			=> $gatewayInfo["username"],
			'userPassword' 		=> $gatewayInfo["password"],
			'orderId' 			=> time(),
			'amount' 			=> $gatewayInfo["amount"],
			'localDate' 		=> date('Ymd'),
			'localTime' 		=> date('Gis'),
			'additionalData' 	=> $gatewayInfo["additionalData"],
			'callBackUrl' 		=> $gatewayInfo["callback"],
			'payerId' 			=> 0
		];
		 
		$client = new \nusoap_client(static::$URL, true);
		$namespace='http://interfaces.core.sw.bps.com/';
		$result = $client->call('bpPayRequest', $parameters, $namespace);
		
		if ($client->fault)
		{
			throw new Exception("There was a problem connecting to Bank", 500);
		} 
		else
		{
			$err = $client->getError();
			if ($err)
			{
				throw new Exception("Error: $err", 500);
			} 
			else
			{	
				if(array_key_exists('return', $result) and $result['return'] != 0){
					throw new Exception("Error: ". static::statusCode($result['return'])." code: ".$result['return'], 500);
				}
				$res = explode (',',$result);
                if ($res[0] == "0")
                {
                    echo '<form name="myform" class="myform" action="https://bpm.shaparak.ir/pgwchannel/startpay.mellat" method="POST">
							<input type="hidden" id="RefId" name="RefId" value="'. $res[1] .'">
							<input type="hidden" id="TerminalId" name="TerminalId" value="'.$parameters['terminalId'].'">
							<input type="hidden" id="UserName" name="UserName" value="'.$parameters['userName'].'">
							<input type="hidden" id="UserPassword" name="UserPassword" value="'.$parameters['userPassword'].'">
							<input type="hidden" id="PayOrderId" name="PayOrderId" value="'.$parameters['orderId'].'">
							<input type="hidden" id="PayAmount" name="PayAmount" value="'.$parameters['amount'].'">
							<input type="hidden" id="PayDate" name="PayDate" value="'.$parameters['localDate'].'">
							<input type="hidden" id="PayTime" name="PayTime" value="'.$parameters['localTime'].'">
							<input type="hidden" id="PayAdditionalData" name="PayAdditionalData" value="'.$parameters['additionalData'].'">
							<input type="hidden" id="PayCallBackUrl" name="PayCallBackUrl" value="'.$parameters['callBackUrl'].'">
							<input type="hidden" id="PayPayerId" name="PayPayerId" value="'.$parameters['payerId'].'">
		                    </form>
		                    <script type="text/javascript">window.onload = formSubmit; function formSubmit() { document.forms[0].submit(); }</script>';
                }
				else
				{
					throw new Exception("Error: $result", 500);
				}
			}
		}
	}

	/**
	*
	* Checking the transaction result 
	*
	* @param array $responseInfo
	*
	* @return mixed
	*/
	public static function verify(array $responseInfo):mixed{
		if ($responseInfo['ResCode'] == '0') {
			$client = new \nusoap_client(static::$URL,true);
			$namespace='http://interfaces.core.sw.bps.com/';
					
			$parameters =  [
				'terminalId' => $responseInfo['terminalId'],
				'userName' => $responseInfo['username'],
				'userPassword' => $responseInfo['password'],
				'orderId' => $responseInfo['orderId'],
				'saleOrderId' => $responseInfo['saleOrderId'],
				'saleReferenceId' => $responseInfo['saleReferenceId']
			];

			$result = $client->call('bpVerifyRequest', $parameters, $namespace);
			if($result == '0') {
				$result = $client->call('bpSettleRequest', $parameters, $namespace);
				if($result == '0') {
					return ['status'=>'success', 'data'=>$result];
				}
			}
			$client->call('bpReversalRequest', $parameters, $namespace);
			throw new Exception("Error: ". $result, 500);	
		} else {
			throw new Exception("Error: ". $_POST['ResCode'], 500);
		}
	}


	/**
	*
	* Checking status code 
	*
	* @param string $code
	*
	* @return string
	*/ 
	private static function statusCode(string $code): string{
		return match ($code) {
		    "0"=>"تراکنش با موفقیت انجام شد",
			"11"=>"شماره کارت نامعتبر است",
			"12"=>" موجودی کافی نیست",
			"13"=>" رمز نادرست است",
			"14"=>"تعداد دفعات وارد کردن رمز بیش از حد مجاز است",
			"15"=>"کارت نامعتبر است",
			"16"=>"دفعات برداشت وجه بیش از حد مجاز است",
			"17"=>"کاربر از انجام تراکنش منصرف شده است",
			"18"=>"تاریخ انقضای کارت گذشته است",
			"19"=>"مبلغ برداشت وجه بیش از حد مجاز است",
			"21"=>"پذیرنده نامعتبر است",
			"23"=>"خطای امنیتی رخ داده است",
			"24"=>"اطلاعات کاربری پذیرنده نامعتبر است",
			"25"=>"مبلغ نامعتبر است",
			"31"=>"پاسخ نامعتبر است",
			"32"=>"فرمت اطلاعات وارد شده صحیح نمی باشد",
			"33"=>"حساب نامعتبر است",
			"34"=>"خطای سیستمی",
			"35"=>"تاریخ نامعتبر است",
			"40"=>"شماره درخواست تکراری است",
			"42"=>"یافت نشد Sale تراکنش",
			"43"=>"قبلا درخواست Verify داده شده است",
			"44"=>"درخواست Verfiy یافت نشد",
			"45"=>"تراکنش Settle (تسویه) شده است",
			"46"=>"تراکنش Settle (تسویه)نشده است",
			"47"=>"تراکنش Settle یافت نشد",
			"48"=>"تراکنش Reverse شده است",
			"49"=>"تراکنش Refund یافت نشد",
			"51"=>"تراکنش تکراری است",
			"54"=>"تراکنش مرجع موجود نیست",
			"55"=>"تراکنش نامعتبر است",
			"61"=>"خطا در واریز",
			"111"=>"صادر کننده کارت نامعتبر است",
			"112"=>"خطای سوییچ صادر کننده کارت",
			"113"=>"پاسخی از صادر کننده کارت دریافت نشد",
			"114"=>"دارنده کارت مجاز به انجام این تراکنش نیست",
			"412"=>"شناسه قبض نادرست است",
			"413"=>"شناسه پرداخت نادرست است",
			"414"=>"سازمان صادر کننده قبض نامعتبر است",
			"415"=>"زمان جلسه کاری به پایان رسیده است",
			"416"=>"خطا در ثبت اطلاعات",
			"417"=>"شناسه پرداخت کننده نامعتبر است",
			"418"=>"اشکال در تعریف اطلاعات مشتری",
			"419"=>"تعداد دفعات ورود اطلاعات از حد مجاز گذشته است",
			"421"=>"IP نامعتبر است",
			default=>$code,
		};
	} 
}
