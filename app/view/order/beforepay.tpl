<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">

    <title>Orders</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <style type="text/css">
    
    </style>
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>




</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th class="text-center">Price(INR)</th>
                        <th class="text-center">Total(INR)</th>
                        <th class="text-center">Payment Mode </th>
                    </tr>
                </thead>
                <tbody>
                     {for $i=0 to $count-1 }
                    
                    <tr>
                        <td class="col-sm-8 col-md-6">

                        <div class="media">
                            <a class="thumbnail pull-left" href="#"> <img class="media-object" src="{$res->suborder[$i]->image}" style="width: 72px; height: 72px;"> </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#">{$res->suborder[$i]->title}</a></h4>
                                <h5 class="media-heading">  <a href="#">{$res->order_id}-{$res->suborder[$i]->suborder_id}<img src="/src/image/logo/{$res->suborder[$i]->platform}.png" height="20" width="20"></a></h5>
                                <span> </span><span class="text-success"><strong></strong></span>
                            </div>
                        </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                        <input type="text" class="form-control" id="exampleInputEmail1" value="{$res->suborder[$i]->qty}" readonly>
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>{$res->suborder[$i]->price}</strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>{$res->suborder[$i]->price * $res->suborder[$i]->qty}</strong></td>
                        <td class="col-sm-1 col-md-1">{if $res->suborder[$i]->cod} COD{else}Online{/if}
                       <td class="col-sm-1 col-md-1 text-center"><strong></td></td>
                    </tr>
            {/for}

                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Subtotal</h5></td>
                        <td class="text-right"><h5><strong>INR {$res->amount}.00</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Estimated shipping</h5></td>
                        <td class="text-right"><h5><strong>INR 0.00</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong> {$res->amount}.00</strong></h3></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>
                        <!-- <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                        </button> --></td>
                        <td>
                        <form action="pay" method="POST">
                        <input type="hidden" name="orderid" value="{$res->order_id}">
                        <input type="hidden" name="amount" value="{$res->amount}">
                        <button type="submit" class="btn btn-success">
                            Pay Now <span class="glyphicon glyphicon-play"></span>
                        </button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>