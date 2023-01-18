<?php

namespace App\Auxiliary\Bank;

use App\Auxiliary\Bank\Gateway;
use Exception;
use Illuminate\Http\RedirectResponse;

class Zarinpal implements Gateway {

	private static $REQUEST_URL = "https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentRequest.json";

	private static $VERIFY_URL = "https://sandbox.zarinpal.com/pg/rest/WebGate/PaymentVerification.json";

	private static $REDIRECT_URL = "https://sandbox.zarinpal.com/pg/StartPay/";

    /**
     * Send the transaction to the bank portal
     * @param array $gatewayInfo
     * @return RedirectResponse|void
     * @throws Exception
     */
    public static function request(array $gatewayInfo){
		$data = [
			"merchantId" => $gatewayInfo['merchantId'],
		    "amount" => $gatewayInfo['amount'],
		    "callback_url" => $gatewayInfo['callback'],
		    "description" => $gatewayInfo['description'],
		    "metadata" => $gatewayInfo['metadata'],
	    ];
		$jsonData = json_encode($data);
		list($result, $err) = static::executeCurl(static::$REQUEST_URL, $jsonData);
		$result = json_decode($result, true, JSON_PRETTY_PRINT);

		if ($err) {
            static::removeRecord($gatewayInfo['metadata']);
			throw new Exception("cUrl Error: $err", 500);
		} else {
		    if (empty($result['errors'])) {
		        if ($result['Status'] == 100) {
		        	return redirect()->away(static::$REDIRECT_URL . $result["Authority"]);
		        }
		    } else {
		    	$status = $result['Status'];
                static::removeRecord($gatewayInfo['metadata']);
		        throw new Exception("cUrl Error: " . static::statusCode($status) . " code: $status" , 500);

		    }
		}
	}


    /**
     * Checking the transaction result
     * @param array $responseInfo
     * @return array
     * @throws Exception
     */
    public static function verify(array $responseInfo){
		$data = [
			"merchant_id" => $responseInfo['merchantId'],
			"authority" => $responseInfo['authority'],
			"amount" => $responseInfo['amount']
		];
		$jsonData = json_encode($data);
		list($result, $err) = static::executeCurl(static::$VERIFY_URL, $jsonData);
		$result = json_decode($result, true);
		if ($err) {
		    throw new Exception("cUrl Error: $err", 500);
		} else {
		    if ($result['Status'] == 100) {
		    	return ['status'=>'success', 'data'=>$result['RefID']];
		    } else {
		    	$status = $result['Status'];
		        throw new Exception("cUrl Error: " . static::statusCode($status) . " code: $status" , 500);
		    }
		}
	}

	/**
	*
	* Call rest api
	*
	* @param string $url
	* @param string $data
	*
	* @return array
	*/
	private static function executeCurl(string $url, string $data):array{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
            'Accept: application/json',
		    'Content-Length: ' . strlen($data)
		));

		$data = [curl_exec($ch), curl_error($ch)];
		curl_close($ch);
		return $data;
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
        switch ($code){
            case '-9':return 'خطای اعتبار سنجی';break;
            case '-10':return 'ای پی و يا مرچنت كد پذيرنده صحيح نيست';break;
            case '-11':return 'مرچنت کد فعال نیست لطفا با تیم پشتیبانی ما تماس بگیرید';break;
            case '-12':return 'تلاش بیش از حد در یک بازه زمانی کوتاه.';break;
            case '-15':return 'ترمینال شما به حالت تعلیق در آمده با تیم پشتیبانی تماس بگیرید';break;
            case '-16':return 'سطح تاييد پذيرنده پايين تر از سطح نقره اي است.';break;
            case '100':return 'عملیات موفق';break;
            case '-30':return 'اجازه دسترسی به تسویه اشتراکی شناور ندارید';break;
            case '-31':return 'حساب بانکی تسویه را به پنل اضافه کنید مقادیر وارد شده واسه تسهیم درست نیست';break;
            case '-32':return 'Wages is not valid, Total wages(floating) has been overload max amount.	';break;
            case '-33':return 'درصد های وارد شده درست نیست';break;
            case '-34':return 'مبلغ از کل تراکنش بیشتر است';break;
            case '-35':return 'تعداد افراد دریافت کننده تسهیم بیش از حد مجاز است';break;
            case '-40':return 'Invalid extra params, expire_in is not valid.	';break;
            case '-50':return 'مبلغ پرداخت شده با مقدار مبلغ در وریفای متفاوت است';break;
            case '-51':return 'پرداخت ناموفق';break;
            case '-52':return 'خطای غیر منتظره با پشتیبانی تماس بگیرید';break;
            case '-53':return 'اتوریتی برای این مرچنت کد نیست';break;
            case '-54':return 'اتوریتی نامعتبر است';break;
            case '101':return 'تراکنش وریفای شده';break;
            case '-21':return 'پرداخت ناموفق';break;
            default: return $code;
        }
	}

    /**
     * Remove record on database
     * @param array $metadata
     * @return void
     */
    private static function removeRecord(array $metadata):void{
        if(array_key_exists('model',$metadata) and array_key_exists('order_id',$metadata)){
            $model = $metadata['model'];
            $model::find($metadata['order_id'])->delete();
        }

    }
}
