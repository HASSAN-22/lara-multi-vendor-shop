<?php


namespace App\Auxiliary\Bank;

class Payment{

	/**
	*
	* Send the transaction to the bank portal 
	*
	* @param Gateway $gateway
	* @param array 	 $responseInfo
	*
	* @return mixed
	*/ 
	public static function request(Gateway $gateway, array $gatewayInfo):mixed{
		return $gateway::request($gatewayInfo);
	}


	/**
	*
	* Checking the transaction result 
	*
	* @param Gateway $gateway
	* @param array 	 $responseInfo
	*
	* @return array|Exception
	*/ 
	public static function verify(Gateway $gateway, array $responseInfo):mixed{
		return $gateway::verify($responseInfo);
	}
}
