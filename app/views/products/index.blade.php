@section('contents')

	@if($products)


	<div class="products-list">
		<table class="data-table">
			<tr>
				<th>Id</th>
				<th>Sku</th>
				<th>Vendor</th>
				<th>Name</th>
				<th>Current Price</th>
				<th>Sold in 30 Days</th>
				<th>Sold in 90 Days</th>
				<th>Sold in 180 Days</th>
				<th>Sold within 1 Year</th>
			</tr>
			@foreach($products as $product)
				<tr>
					<td>{{$product->id}}</td>
					<td>{{link_to_action('ProductsController@show',$product->sku,array($product->id),array('target'=>'_blank'))}}</td>\
					<td>{{$product->vendor}}</td>
					<td>{{$product->name}}</td>
					<td>{{$product->current_price}}</td>
					<td>{{$product->howManySoldIn(30)}}</td>
					<td>{{$product->howManySoldIn(90)}}</td>
					<td>{{$product->howManySoldIn(180)}}</td>
					<td>{{$product->howManySoldIn(365)}}</td>
				</tr>
			@endforeach
		</table>
		<?php echo $products->links(); ?>
	</div>
	@endif
@stop