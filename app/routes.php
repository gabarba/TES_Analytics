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
	$orderItems = OrderItem::where('products_id',0)->get();

	foreach($orderItems as $item) {
		$product_id = Products::where('sku',$item->sku)->first();

		if($product_id) {
			$item->products_id = (int)$product_id->id;
			$item->product_mapped = 1;
			$item->save();
		}
	}
	//$customers = Customers::where('avg_time_between_orders','>',0)->avg('avg_time_between_orders');
	//$customers = Customers::where('country_code','US')->where('state','CA')->count();
	return "Product Id ASSOC Complete!";
});


//Route::get('/','SummaryController@getSummary');