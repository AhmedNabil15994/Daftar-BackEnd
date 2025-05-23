<?php
namespace Modules\Transaction\Services;

class PaymentServiceV2
{
		// LIVE CREDENTIALS
		// const MERCHANT_ID    = "4746";
    // const USERNAME 			 = "daftarkw";
		// const PASSWORD     	 = "mEyCWGJ/57#z/{85";
    // const API_KEY        = "Ac16aaCGbM7isqbjJRflf63w3ODzsWOJ3vmyZhri";

		public function send($order,$type,$payment)
		{
				$url = $this->paymentUrls($type);

				$fields = [
					'api_key'					=> (app()->environment() == 'production') ?
															 password_hash(env('PAYMENT_API_KEY'),PASSWORD_BCRYPT) :
															 env('PAYMENT_API_KEY'),
					'merchant_id'			=> env('PAYMENT_MERCHANT_ID'),
					'username' 				=> env('PAYMENT_USERNAME'),
					'password' 	 			=> (app()->environment() == 'production') ?
															 stripslashes(env('PAYMENT_PASSWORD')) :
															 env('PAYMENT_PASSWORD'),
					'order_id' 				=> $order['id'],
					'CurrencyCode'		=> 'KWD', //only works in production mode
					'CstFName' 				=> auth()->user() ? auth()->user()->name : 'null',
					'CstEmail'				=> auth()->user() ? auth()->user()->email : 'null',
					'CstMobile'				=> auth()->user() ? auth()->user()->mobile : 'null',
					'success_url'   	=> $url['success'],
					'error_url'				=> $url['failed'],
					'test_mode'    		=> env('PAYMENT_TEST_MODE'),
					'whitelabled'    	=> false,
					'payment_gateway'	=> $payment,// knet / cc
					'reference'				=> $order['id'],
					// 'notifyURL'			  => '',
					'total_price'			=> $order['total'],
				];

				$fields_string = http_build_query($fields);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,env('PAYMENT_URL')); curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); $server_output = curl_exec($ch);
				curl_close($ch);
				$server_output = json_decode($server_output,true);

				return $server_output['paymentURL'];
		}

    public function paymentUrls($type)
    {
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
