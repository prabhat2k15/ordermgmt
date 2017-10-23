<?php

namespace app\controller {

use app\service\OrderService;
use app\service\PayService;
use \app\service\R;
    
    class OrderController extends AbstractController
    {

          /**
         * @RequestMapping(url="order/place", method="GET", type="json")
         * @RequestParams(true)
         */
        public function placeOrder($order)
        {
        	$order='{
				"uid": "1",
				"product": [
					{
						"pid": 2,
						"qty": 2,
						"price": 1062,
						"cod": true
					},
					{
						"pid": 1,
						"qty": 1,
						"price": 759,
						"cod": false
					}
				]
			}';

        	return OrderService::placeOrder(json_decode($order));

        }

 		/**
         * @RequestMapping(url="order/beforepay", method="GET", type="template")
         * @RequestParams(true)
         */
        public function beforepay($model,$orderid)
        {

        	$res=OrderService::getOrder($orderid);
        	// echo '<pre>';
        	// print_r($res);die;
        	$model->assign('res',$res);
        	$model->assign('count',count($res->suborder));

        	return 'order/beforepay';

        }

        /**
         * @RequestMapping(url="order/pay", method="POST", type="json")
         * @RequestParams(true)
         */
        public function pay($orderid)
        {
        	return OrderService::pay($orderid);

        }
        /**
         * @RequestMapping(url="order/afterpay", method="GET", type="json")
         * @RequestParams(true)
         */
        public function afterpay($order_id,$payment_id, $payment_request_id)
        {
        	// $payment_id='MOJO7a13005A58691171';
        	// $payment_request_id='13d8204f080940eb837d442361e41445';
        	// echo $payment_id .'<br>'. $payment_request_id;

       	 $res = PayService::payStatus($payment_id, $payment_request_id);
       	 // print_r($res);die;

       	 $obean = R:: findOne('order','oid=?',[$order_id]);
       	 $obean->payment_status=$res['status'];
       	 $obean->paymentid=$payment_id;
       	 $obean->paymentrequestid=$payment_request_id;
       	 $obean->payment_at=R::isoDateTime();
       	 R::store($obean);

       	 return $res['status'];

       	 


        }









        /**
         * @RequestMapping(url="order/view",type="template")
         * @RequestParams(true)
         */
        public function order($model=null,$qr=2, $oid, $soid)
        {
        	// echo "string".$qr.$oid.$soid;
        	$orders = OrderService::getAllOrder($qr,$oid,$soid);
        	$model->assign('orders',$orders);
        	$model->assign('count',count($orders));

            return 'order/view';
        }





         /**
         * @RequestMapping(url="order/save", method="GET", type="template")
         * @RequestParams(true)
         */
        public function saveOrder($order)
        {
        	$order = $this->getOrder();

        	echo OrderService::saveOrder($order);

        	die;
        }

    }
}





































				



/*        	$order='{
						"orders": {
							
							"order_id": "IYIU324",

							"user": {
								"user_id": "vaibhav2k11",
								"name": "Vaibhav Kumar",
								"address_type": "Home",
								"address": "sec 55 Gate No 4",
								"city": "Noida",
								"state": "UP",
								"pincode": "201301",
								"email" : "vaibhav2k11@gmail.com",
								"mobile": "8984772994"
							},
							"order": {
								"0": {
									"sub_order_id": "23476",
									"product_id": "555",
									"title": "Printed Red Saree",
									"selling_price": 1498,
									"discount": 20,
									"platform" : "Flipkart",
									"platform_order_id" : "BJJKJE1212",
									"delivery_date" : "2017-06-16",
									"status" : true,
									"details" : "Payment Success and Ordered successfully"
								},
								"1": {
									"sub_order_id": "34523",
									"product_id": "666",
									"title": "blue saree",
									"selling_price": 1498,
									"discount": 20,
									"platform" : "Myntra",
									"platform_order_id" : "HKKHKKHKH76576",
									"delivery_date" : "2017-06-16",
									"status" : true,
									"details" : "Payment Success and Ordered successfully"

								},
								"2": {
									"sub_order_id": "45064",
									"product_id": "777",
									"title": "blue saree",
									"selling_price": 1498,
									"discount": 20,
									"platform" : "Myntra",
									"platform_order_id" : "HKKHKKHKH76576",
									"delivery_date" : "2017-06-16",
									"status" : false,
									"details" : "Payment Success and but not Ordered"

								}
							}
						}
					}';
*/