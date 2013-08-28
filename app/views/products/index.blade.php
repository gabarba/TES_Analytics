@section('contents')

	@if($products)


	<div class="products-list">
		<table class="data-table">
			<tr>
				<th>Id</th>
				<th>Sku</th>
				<th>Name</th>
				<th>Current Price</th>
			</tr>
			@foreach($products as $product)
				<tr>
					<td>{{$product->id}}</td>
					<td>{{$product->sku}}</td>
					<td>{{$product->name}}</td>
					<td>{{$product->current_price}}</td>
				</tr>
			@endforeach
		</table>
	</div>
	@endif
@stop