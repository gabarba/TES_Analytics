@section('contents')

	@if($customer)

	
	<table class="table table-hover table-bordered">
			
			@foreach($customer->info() as $key => $info)
				<tr>
					<td>{{$key}}</td>
					<td>{{$info}}</td>
				</tr>
			@endforeach
		</table>

	<div class="customer-orders">
		<table class="table table-hover table-bordered">
			<tr>
				<th>Order Date</th>
				<th>Shipworks Order ID</th>
			</tr>
			@foreach($customer->orders as $order)
				<tr>
					<td>{{$order->order_date}}</td>
					<td>{{$order->shipworks_order_id}}</td>
					<td>
						
							<table class="table table-hover table-bordered">
								<tr>
									<th>Name:</th>
									<th>SKU:</th>
									<th>QTY:</th>
									<th>Unit Price:</th>
									<th>Total:</th>
								</tr>
								@foreach($order->items as $item)
									<tr>
										<td>{{$item->name}}</td>
										<td>{{($item->product_id == 0? link_to_action('ProductsController@show',$item->sku,array($item->products_id),array('target'=>'_blank')):$item->sku) }}</td>
										<td>{{$item->qty}}</td>
										<td>{{$item->unit_price}}</td>
										<td>{{$item->total}}</td>
									</tr>
								@endforeach
								<tr>
									<td>Totals</td>
									<td></td>
									<td>{{$order->calculatedQtyTotal()}}</td>
									<td></td>
									<td>{{$order->calculatedOrderTotal()}}</td>
								</tr>
							</table>						
					</td>
				</tr>
			@endforeach
		</table>
	</div>
	@endif
@stop