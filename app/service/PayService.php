<?php
namespace app\service {

use Instamojo\Instamojo;

  class PayService
  {

    public  function pg($amount,$orderid)//PLCAE ORDER
    {
    	$api=new Instamojo('73ff3363ba9eb79ef8da85266f7e3089', 'f3f10b7f9be4b69906421cd564d4039f', 'https://test.instamojo.com/api/1.1/');

	   try {
	    $response = $api->paymentRequestCreate(array(
	        "purpose" => "MS Purchase",
	        "amount" => $amount,
	        "send_email" => false,
	        "email" => "prabhat2k15@gmail.com",
	        "redirect_url" => "http://productservice.dev/order/afterpay?order_id=".$orderid
	        ));


            header("Location:".$response['longurl']);



		}
		catch (Exception $e) {
	    print('Error: ' . $e->getMessage());
		}
	}

	public  function payStatus($payment_id, $payment_request_id)
	{
		$api=new Instamojo('73ff3363ba9eb79ef8da85266f7e3089', 'f3f10b7f9be4b69906421cd564d4039f', 'https://test.instamojo.com/api/1.1/');
		
		try {
		    $response = $api->paymentRequestStatus($payment_request_id);
		   
		}
		catch (Exception $e) {
		    print('Error: ' . $e->getMessage());
		}
		 return $response;
	}
  }
}