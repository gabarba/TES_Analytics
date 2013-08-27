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
	$customers = Customers::where('avg_time_between_orders','>',0)->avg('avg_time_between_orders');
	//$customers = Customers::where('country_code','US')->where('state','CA')->count();
	return "Average Days Between Orders Customers who ordered more than once: ".$customers;
});