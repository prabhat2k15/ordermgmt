<?php
namespace app\service {


  class OrderService
  {
   

    public static function placeOrder($order)//PLCAE ORDER
    {
      // print_r($order);die;

       $oBean=R::dispense('order');
       $oBean->oid= 'MS'.Random::Alphabets(6);
       $oBean->uid=$order->uid;
       $id = R::store($oBean);

       foreach ($order->product as $key => $pid) {
         $soBean=R::dispense('suborder');
         $soBean->soid=Random::Numeric(6);
         $soBean->oid=$id;
         $soBean->pid=$pid->pid;
         $soBean->qty=$pid->qty;
         $soBean->price=$pid->price;
         $soBean->cod=$pid->cod;
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
             //   echo '<pre>';
             // print_r($suborder);

               $i=0; $amount=0;
               foreach ($suborder as $s) 
               {
                 $r['suborder'][$i]['id']=$s->id;
                 $r['suborder'][$i]['suborder_id']=$s->soid;

                 $subproduct=R::findOne('subproduct','id=?',[$s->pid]);
                 $superproduct=R::findOne('superproduct','id=?',[$subproduct->sid]);
                 $source=R::findOne('source','subid=?',[$s->pid]);

                 $r['suborder'][$i]['pid']  =$s->id;
                 $r['suborder'][$i]['title']=$source->title;
                 $r['suborder'][$i]['image']=$source->image;
                 $r['suborder'][$i]['description']=$source->description;
                 $r['suborder'][$i]['price']=$s->price;
                 $r['suborder'][$i]['qty']  =$s->qty;
                 $r['suborder'][$i]['cod']  =$s->cod;
                 $amount+=$s->price * $s->qty;
                 $i++;
               }
               $r['amount']=$amount;
// MSPHEPSF
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
        if(!$so->cod){
          $amount+= $so->price * $so->qty;
        }
      }
      echo $amount;
      PayService::pg($amount);

    }

    public static function afterpay(){}



















     public static function getAllOrder($qr,$oid,$soid)
    {
      if(isset($oid) || isset($soid))
      {
        // echo $oid.'-'.$soid;
        if(!empty(trim($oid)) && empty(trim($soid)))
        {           
            $order=R::find('order','oid=?',[$oid]);
            $i=0; 
              foreach ($order as $o) {
                $r[$i]['id']=$o->id;
                $r[$i]['order_id']=$o->oid;
                $r[$i]['user']=R::load('customer',$o->uid);
                $r[$i]['order']=R::find('suborder','oid=?',array($o->id));
                // $i++;
              }
        return (json_decode(json_encode($r)));
        }
        if(!empty(trim($soid)))
        {
          $suborder=R::findOne('suborder','soid=?',[$soid]);
            if(!$suborder){ return 0; }
          $order=R::find('order','id=?',[$suborder->oid]);
            $i=0; 
              foreach ($order as $o) {
                $r[$i]['id']=$o->id;
                $r[$i]['order_id']=$o->oid;
                $r[$i]['user']=R::load('customer',$o->uid);
                $r[$i]['order']=R::find('suborder','soid=?',array($soid));
              }
        return (json_decode(json_encode($r)));
        }
      }
      switch($qr)
      {
        case 1:
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

      return (json_decode(json_encode($r)));

    }



  }
}





























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