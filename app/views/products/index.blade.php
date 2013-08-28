@section('contents')

	@if($products)

	
	<div class="customer-info">
		@foreach($customer->info() as $key => $info)
		<div class="data-line">	
			<div class="label">{{$key}}:</div>
			<div class="value">{{$info}}</div>
		</div>	
		@endforeach
	</div>

	<div class="customer-orders">
		<table class="data-table">
			<tr>
				<th>Order Date</th>
				<th>Shipworks Order ID</th>
			</tr>
			@foreach($customer->orders as $order)
				<tr>
					<td>{{$order->order_date}}</td>
					<td>{{$order->shipworks_order_id}}</td>
					<td>
						
							<table class="data-table full">
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
										<td>{{$item->sku}}</td>
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