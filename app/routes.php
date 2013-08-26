<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::resource('customers','CustomersController');

Route::get('customers/OrderItemsGreaterThan/{count}','CustomersController@orderItemsCount');

Route::get('/', function()
{
	$orderItems = OrderItem::where('order_id',0)->get();

	foreach($orderItems as $item) {
		$linkItemTo = Orders::where('shipworks_order_id',$item->shipworks_order_id)->first();
		if($linkItemTo) {
			$item->order_id = $linkItemTo->id;
			$item->save();
		};
		
	};
	return "Relations Complete";
});