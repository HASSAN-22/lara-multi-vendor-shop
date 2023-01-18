<?php


namespace App\Auxiliary\Bank;

use Illuminate\Http\RedirectResponse;

interface Gateway{

	/**
	*
	* Send the transaction to the bank portal
	*******************************
	#	To send the information of `Zarinpal` portal, send gateway Info like this
	#	[
	#		+	amount=>type(int),
	#		+	merchantId=>type(str),
	#		+	callback=>type(str),
	#		+	(optional)description=>type(str),
	#		+	(optional)metadata=>type(array) => You can set `model` and `order_id` for delete record in database if transaction get error
	#	]
	*******************************
	#	To send the information of `Melat` portal, send gateway Info like this
	#	[
	#		+	terminalId=>type(int),
	#		+	username=>type(str),
	#		+	password=>type(str),
	#		+	amount=>type(str),
	#		+	callback=>type(str),
	#		+	(optional)additionalData=>type(str),
	#	]
	*******************************
	#
	*
	* @param array $gatewayInfo
	*
    * @return RedirectResponse|void
    * @throws \Exception
	*/
    public static function request(array $gatewayInfo);

	/**
	*
	* Checking the transaction result
	*
	*******************************
	#	To send the information of `Zarinpal` portal, send gateway Info like this
	#	[	+   amount=>type(str),
	#		+	authority=>type(int),
	#		+	mmerchantId=>type(str),
	#	]
	*******************************
	#	To send the information of `Melat` portal, send gateway Info like this
	#	[	+   terminalId=>type(str),
	#		+	username=>type(int),
	#		+	password=>type(str),
	#		+	saleOrderId=>type(str),
	#		+	saleReferenceId=>type(str),
	#	]
	*******************************
	#
	*
	* @param array $responseInfo
    * @return RedirectResponse|void
    * @throws \Exception
	*/
	public static function verify(array $responseInfo);
}
