<?php

namespace Modules\Transaction\Services;

class PaymentService
{
	// LIVE CREDENTIALS
	const MERCHANT_ID    = "4746";
	const USERNAME 		 = "daftarkw";
	const PASSWORD     	 = "mEyCWGJ/57#z/{85";
	const API_KEY        = "Ac16aaCGbM7isqbjJRflf63w3ODzsWOJ3vmyZhri";

	// TEST CREDENTIALS
	const TEST_MERCHANT_ID    	= "1201";
	const TEST_USERNAME 		= "test";
	const TEST_PASSWORD     	= "test";
	const TEST_API_KEY        	= "jtest123";

	public function send($order, $type, $payment, $paymentType = 'test')
	{
		$url = $this->paymentUrls($type);

		$fields = [
			// 'api_key'				=> self::API_KEY,
			'api_key'				=> $paymentType == 'test' ? self::TEST_API_KEY : password_hash(self::API_KEY, PASSWORD_BCRYPT),
			'merchant_id'			=> $paymentType == 'test' ? self::TEST_MERCHANT_ID : self::MERCHANT_ID,
			'username' 				=> $paymentType == 'test' ? self::TEST_USERNAME : self::USERNAME,
			// 'password' 				=> self::PASSWORD,
			'password' 				=> $paymentType == 'test' ? self::TEST_PASSWORD : stripslashes(self::PASSWORD),
			'order_id' 				=> $order['id'],
			'CurrencyCode'			=> 'KWD', //only works in production mode
			'CstFName' 				=> auth()->user() ? auth()->user()->name : 'null',
			'CstEmail'				=> auth()->user() ? auth()->user()->email : 'null',
			'CstMobile'				=> auth()->user() ? auth()->user()->mobile : 'null',
			'success_url'   		=> $url['success'],
			'error_url'				=> $url['failed'],
			// 'test_mode'    		=> 1, // test mode enabled
			'test_mode'    			=> $paymentType == 'test' ? 1 : 0,
			'whitelabled'    		=> false,
			'payment_gateway'		=> $payment, // knet / cc
			'reference'				=> $order['id'],
			'notifyURL'				=> url(route('frontend.orders.webhooks')),
			'total_price'			=> $order['total'],
		];

		if ($paymentType == 'test')
			$apiUrl = "https://api.upayments.com/test-payment";
		else
			$apiUrl = "https://api.upayments.com/payment-request";

		$fields_string = http_build_query($fields);
		$ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL,"https://api.upayments.com/test-payment"); curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL, $apiUrl);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$server_output = curl_exec($ch);
		curl_close($ch);
		$server_output = json_decode($server_output, true);

		return $server_output['paymentURL'];
	}

	public function paymentUrls($type)
	{
		if ($type == 'api-orders') {
			$url['success'] = url(route('api.orders.success'));
			$url['failed']  = url(route('api.orders.success'));
		}

		if ($type == 'orders') {
			$url['success'] = url(route('frontend.orders.success'));
			$url['failed']  = url(route('frontend.orders.success'));
		}

		if ($type == 'subscriptions') {
			$url['success'] = url(route('frontend.subscriptions.success'));
			$url['failed']  = url(route('frontend.subscriptions.success'));
		}

		return $url;
	}
}
