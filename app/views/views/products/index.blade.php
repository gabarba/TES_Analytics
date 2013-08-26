@section('contents')
	<h1>Product List</h1>
	<ul class="product-list">
	@foreach($products as $product)
		<li>{{$product->title}}</li>
	@endforeach
	</ul>
@stop