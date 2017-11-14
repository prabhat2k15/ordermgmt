<?php

namespace app\controller {

use app\service\OrderService;
use app\service\PayService;
use app\service\MailService;
use \app\service\R;
    
    class OrderController extends AbstractController
    {

          /**
         * @RequestMapping(url="order/place", method="GET", type="json")
         * @RequestParams(true)
         */
        public function placeOrder($order)
        {
                return OrderService::placeOrder(json_decode($order));
        }

        /**
         * @RequestMapping(url="order/beforepay", method="GET", type="template")
         * @RequestParams(true)
         */
        public function beforepay($model,$orderid)
        {

                $res=OrderService::getOrder($orderid);
//             echo '<pre>';
//             print_r($res);die;
            if($res->amount<=0){
                header('Location:http://orderservice.modestreet.in/order/afterpay?order_id='.$orderid.'&status=1');
                exit();
            }else{
                $model->assign('res',$res);
                $model->assign('count',count($res->suborder));
//              //header('Location:http://orderservice.modestreet.in/order/afterpay?order_id='.$orderid.'&status=0');

        $this->pay($orderid);
            }

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
        public function afterpay($order_id,$payment_id, $payment_request_id,$status=0)
        {
                // $payment_id='MOJO7a24005A94920430';
                // $payment_request_id='d29d28764ee14811b65f80fdf124fac1';
                echo $payment_id .'<br>'. $payment_request_id;
            echo 'status='.$status.$order_id;
            // die;
            if($status==1){
                    $obean = R::findOne('order','oid=?',[$order_id]);
                    $obean->payment_status='offline';
                   $obean->status=true;
                    $obean->payment_at=R::isoDateTime();
                    R::store($obean);
            }else{
                $res = PayService::payStatus($payment_id, $payment_request_id);
                 print_r($res);
                 if($res['payments'][0]['status']=='Credit')
                 {
                    $obean = R::findOne('order','oid=?',[$order_id]);
                    $obean->payment_status=$res['status'];
                    $obean->paymentid=$payment_id;
                    $obean->paymentrequestid=$payment_request_id;
                    $obean->status=true;
                    $obean->payment_at=R::isoDateTime();
                    R::store($obean);
                }
            }

                 MailService::mail($order_id);
            echo $obean->uid.$order_id.$obean->status;
            header('Location:http://beta.modestreet.in/order-history');
            //header('Location:http://orderservice.modestreet.in/order/save?uid='.$obean->uid.'orderid='.$order_id.'&status='.$obean->status);

            die;

            // header('Location:http://dev.modestreet.in/api/order/checkoutcallback?uid='.$obean->uid.'orderid='.$order_id.'&status='.$obean->status);
 
        //return true;


        }
    /**
         * @RequestMapping(url="order/view",type="template")
         * @RequestParams(true)
         */
        public function order($model=null,$qr=2, $oid, $soid)
        {
                $orders = OrderService::getAllOrder($qr,$oid,$soid);
            // echo count($orders);
            // echo '<pre>';
            // print_r($orders);die;
                $model->assign('orders',$orders);
                $model->assign('count',count($orders));

            return 'order/view';
        }


        /**
         * @RequestMapping(url="order/getorder/{orderid}",type="json")
         * @RequestParams(true)
         */
        public function getOrder($model=null,$orderid)
        {
            $orders = OrderService::getAllOrder(2,$orderid);
            // echo count($orders);
            // echo '<pre>';
            // print_r($orders);die;

            return $orders;
        }
         /**
         * @RequestMapping(url="order/save", method="GET", type="json")
         * @RequestParams(true)
         */
        public function saveOrder($uid,$orderid,$status) 
        {
            echo $_SERVER['DOCUMENT_ROOT'].'src/image/pdf/';
            // echo $order??"no odere";
            // return $order??"no odere";
            // die;

                // $order = $this->getOrder();

                // echo OrderService::saveOrder($order);

                // die;
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