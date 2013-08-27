<?php

class SummaryController extends \BaseController {



	protected $layout = 'layouts.base';


	public function orderItemsCount($count) 
	{
		$customers = array();
		$orders = Orders::has('items','>=',$count)->get();

		foreach($orders as $order) {
			if(!array_key_exists($order->customer->id, $customers)){
				$customers[$order->customer->id] = $order->customer->name;
				}	
		}

		$this->layout->contents = View::make('customers.orderItemsCount', compact('customers'));
	}
	
	public function getSummary()
	{
		$this->layout->contents = View::make('summary.index',compact('data'));
	}
}