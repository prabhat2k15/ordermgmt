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
<a href="view"> All Orders</a> | 
<a href="view?qr=1"> Successful Orders</a> | 
<a href="view?qr=0"> Failed Orders</a> | 
<form action="view" method="GET" style="float: right;">
	<input type="text" name="oid" placeholder="Order ID">
	<input type="text" name="soid" placeholder="Sub-Order ID">
	<input type="submit" value="Search">
</form>
  <h6>Search List     Count : {$count}</h6>
  <p> </p>            
  <table class="table table-striped">
    <thead>
      <tr>
        <th>OrderId</th>
        <th>User</th>
        <th>Product</th>
      </tr>
    </thead>
    <tbody>
 {for $i=0 to $count-1 }

      <tr>
        <td>{$orders[$i]->id}.{$orders[$i]->order_id}</td>
        <td><h6 style="margin: 0;">{$orders[$i]->user->uid}<br>
        	  [{$orders[$i]->user->address_type}]
        		{$orders[$i]->user->name}<br>
        		{$orders[$i]->user->address}
        		{$orders[$i]->user->city}
        		{$orders[$i]->user->state}
        		{$orders[$i]->user->pincode}<br>
        		{$orders[$i]->user->mobile},
        		{$orders[$i]->user->email}
        		</h6> </td>
        <td><table>
        {foreach $orders[$i]->suborder as $o}
        	<tr>
        	{if $o->status}
        	{assign var="failed" value="color:black;"}
        	{else}
        	{assign var="failed" value="color:red;"}
        	{/if}
        		<td><h6 style="margin: 0;">{$o->suborder_id}-{$o->pid}-{$o->title}<br>Rs.{$o->price}</td>
        		<td><h6 style="margin: 0;{$failed}">{$o->platform}<br>{$o->platform_oid}</td>
        	</tr>
        {/foreach}	
        </table></td>
        <td></td>
        <!-- 
        <td>{round((($orders[$i]->priceoriginal[$i]-$orders[$i]->price[$i])/$orders[$i]->priceoriginal[$i])*100)}</td>
        <td><form action="/page/1" method="POST">
        <input type="hidden" name="url" value="{$orders[$i]->link[$i]}">
        <input type="hidden" name="subid" value="{$superorders[$i]->id}">
        <button type="submit" name="" value="Save" class="btn btn-primary btn-block">Save</button>
            </form></td> -->
      </tr>
{/for}
    </tbody>
  </table>
</div>
</body>
</html>
