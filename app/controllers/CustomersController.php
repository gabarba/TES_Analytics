<?php

class CustomersController extends \BaseController {



	protected $layout = 'layouts.base';


	public function orderItemsCount($count) 
	{
		$customers = array();
		$orders = Orders::with('customer')->has('items','>=',$count)->get();

		foreach($orders as $order) {
			if(!array_key_exists($order->customer->id, $customers)){
				$customers[$order->customer->id] = $order->customer->name;
				}	
		}

		$this->layout->contents = View::make('customers.orderItemsCount', compact('customers'));
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$customer = Customers::where('id',$id)->with('orders.items')->first();

		$this->layout->contents = View::make('customers.show',compact('customer'));

		//return $customer->toJson();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}