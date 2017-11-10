<?php
namespace app\service {


  class OrderService
  {
   

    public static function placeOrder($order)//PLACE ORDER
    {
      // print_r($order);die;

       $oBean=R::dispense('order');
       $oBean->oid= 'MS'.Random::Alphabets(6);
       $oBean->uid=$order->uid;
       $oBean->created_at=R::isoDateTime();
       $id = R::store($oBean);

       foreach ($order->products as $key => $pid) {
         $soBean=R::dispense('suborder');
         $soBean->soid=Random::Numeric(6);
         $soBean->oid=$id;
         $soBean->subid=$pid->product_id;
         $soBean->pid=$pid->source_id;
         $soBean->qty=$pid->quantity;
         // $soBean->price=$pid->price;
         $soBean->cod=$pid->cod;
         $soBean->status=$pid->cod;
         R::store($soBean);
       }
      

       return $oBean->oid; 
    }



    public static function getOrder($oid)
    {
            $order=R::findOne('order','oid=?',[$oid]);
                $r['id']=$order->id;
                $r['order_id']=$order->oid;
                $r['user']=R::load('customer',$order->uid);
               $suborder=R::find('suborder','oid=?',array($order->id));

               $i=0; $amount=0;
               foreach ($suborder as $s) 
               {
                 $r['suborder'][$i]['id']=$s->id;
                 $r['suborder'][$i]['suborder_id']=$s->soid;

                 // $subproduct=R::findOne('subproduct','id=?',[$s->pid]);
                 // $superproduct=R::findOne('superproduct','id=?',[$subproduct->sid]);
                 // $source=R::findOne('source','subid=?',[$s->pid]);
                 // $platform=R::load('host',$source->hostid);
                 $source=R::load('source',$s->pid);
                 $price=R::load('price',$source->priceid);
                 $platform=R::load('host',$source->hostid);
                 
                 $r['suborder'][$i]['pid']  =$s->id;
                 $r['suborder'][$i]['title']=$source->title;
                 $r['suborder'][$i]['image']=$source->image;
                 $r['suborder'][$i]['description']=$source->description;
                 $r['suborder'][$i]['price']=$price->price;
                 $r['suborder'][$i]['qty']  =$s->qty;
                 $r['suborder'][$i]['cod']  =$s->cod;
                 $r['suborder'][$i]['status']=$s->cod;
                 $r['suborder'][$i]['platform']=$platform->title;
                 $amount+=$s->cod? 0 :$price->price * $s->qty;
                 $i++;
               }
               $r['amount']=$amount;
        //        echo '<pre>';
        // print_r(json_decode(json_encode($r))); die;
        return(json_decode(json_encode($r))); 
    }




    public static function pay($orderid)
    {
      // echo $orderid.'processsing';
      // die;
      $oBean=R::findOne('order','oid=?',[$orderid]);
      $soBean=R::find('suborder','oid=?',[$oBean->id]);
      $amount=0;
      foreach ($soBean as $so) {
        $source=R::load('source',$so->pid);
        $price=R::load('price',$source->priceid);
        if(!$so->cod){
          $amount+= $price->price * $so->qty;
        }
      }
      // echo $amount; die;
      return PayService::pg($amount,$orderid);

    }

    public static function afterpay($response)
    {}



     public static function getAllOrder($qr,$oid,$soid)
    {
      if(isset($oid) || isset($soid))
      {
         if(!empty(trim($soid))){
          $suborder=R::findOne('suborder','soid=?',[$soid]);
          $order=R::load('order',$suborder->oid);
          $orders[]=self::getOrder($order->oid);
          foreach ($orders[0]->suborder as $key => $so) {
            if($so->suborder_id!=$soid){
              unset($orders[0]->suborder[$key]);
            }
          }
          // print_r($order);die;
          return $orders;

        }else if(!empty(trim($oid)) && empty(trim($soid))){   
          $orders[]=self::getOrder($oid); 
          return $orders;
        }
      }
      switch($qr)
      {
            /* 1.Successful order
               0.Failed order 
         default.All orders */
        case 1:
        case 0: $order=R::find('order');
                foreach ($order as $o) {
                  $temp=self::getOrder($o->oid);

                  foreach ($temp->suborder as $key => $so) {
                    if($so->status!==$qr){
                      unset($temp->suborder[$key]);
                    }
                  }
                  if(empty($temp->suborder)){
                      unset($temp);
                  }
                  if(!empty($temp)){
                  $orders[]=$temp;
                  }
                }
                
                   // echo '<pre>';
                   //  print_r($orders); die;
                 
               return $orders; 

              break;
       default:
          $order=R::find('order');
          foreach ($order as $o) {
            $orders[]=self::getOrder($o->oid);
          }
          return $orders;
      }

      return 0;


    }



  }
}







/*
if(isset($oid) || isset($soid))
      {
        if(!empty(trim($oid)) && empty(trim($soid)))
        {   
          $orders[]=self::getOrder($oid); 
          return $orders;
        }
        if(!empty(trim($soid)))
        {
          $suborder=R::findOne('suborder','soid=?',[$soid]);
          $order=R::load('order',$suborder->oid);
          
          print_r($order);die;

          return (json_decode(json_encode($r)));
        }
      }
      switch($qr)
      {
        /* 1.Successful order
           0.Failed order 
     default.All orders */
/*        case 1:
        case 0: $order=R::find('order');
            $i=0; 
            foreach ($order as $o) 
            {
              if(R::findOne('suborder','status=? AND oid=?',array($qr,$o->id)))
              {
                $r[$i]['id']=$o->id;
                $r[$i]['order_id']=$o->oid;
                $r[$i]['user']=R::load('customer',$o->uid);
                $r[$i]['order']=R::find('suborder','oid=? AND status=?',array($o->id,$qr));
                $i++;
              } 
            }
              break;
      default:$order=R::find('order');
            $i=0;
            foreach ($order as $o) {
              $r[$i]['id']=$o->id;
              $r[$i]['order_id']=$o->oid;
              $r[$i]['user']=R::load('customer',$o->uid);
              $r[$i]['order']=R::find('suborder','oid=?',[$o->id]);
              $i++;
            }
      }

      return (json_decode(json_encode($r)));*/






















/*
stdClass Object
(
    [orders] => stdClass Object
        (
            [user] => stdClass Object
                (
                    [user_id] => prabhat2k15
                    [name] => Prabhat Kumar
                    [address_type] => Home
                    [address] => C2
                    [city] => Noida
                    [state] => UP
                    [pincode] => 201301
                    [mobile] => 9835433153
                )

            [order] => stdClass Object
                (
                    [order_id] => AXIZW
                    [0] => stdClass Object
                        (
                            [sub_order_id] => 1234
                            [product_id] => 111
                            [title] => Blue Jeans
                            [selling_price] => 498
                            [discount] => 40
                            [platform] => Flipkart
                            [platform_order_id] => BJJKJE1212
                        )

                    [1] => stdClass Object
                        (
                            [sub_order_id] => 1235
                            [product_id] => 222
                            [title] => Red Shirt
                            [selling_price] => 1498
                            [discount] => 20
                            [platform] => Jabong
                            [platform_order_id] => HKKHKKHKH76576
                        )

                )

        )

)
*/