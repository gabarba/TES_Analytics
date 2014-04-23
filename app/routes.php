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
Route::group(array('before'=>'auth.basic'), function() 
{
	Route::resource('customers','CustomersController');
	Route::resource('products','ProductsController');

	Route::controller('import','ImportController');

	Route::get('customers/OrderItemsGreaterThan/{count}','CustomersController@orderItemsCount');
	Route::get('customers/thatordered/{sku}','CustomersController@thatOrdered');
	/*
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
	*/

	Route::get('/', function(){
		//$products = Products::with('itemsSold','itemsSold.order')->where('manufacturer','Explore Scientific')->get(array('id','sku','name','vendor'));
		$vendors = Products::distinct()->get(array('vendor'));
		$output = array();
		foreach($vendors as $vendor)
		{
			$total = null;
			$products = Products::where('vendor',$vendor->vendor)->get()->each(function($product) use (&$total) {
				$total += $product->earnedBetween('2013-01-01','2013-12-31');
			});
			$output[$vendor->vendor] = $total;
		}
		

		return View::make('vendorstats',compact('output'));
	});

	Route::get('/dev', function()
	{
		/*
		$days = array(
					7 =>'Sold in 7 Days',
					14 =>'Sold in 14 Days',
				);
				*/
		$salesData = Products::ReturnSalesCount();

		$queries = DB::getQueryLog();
		$last_query = $queries;

		$salesData = $salesData->skip(Input::get('page',1)*10+1)->take(10)->get()->toArray();
		$paginator = Paginator::make((array)$salesData,Products::count(),10);
		return $paginator->toArray();
		//return $last_query;
	});
});