@section('contents')

	@if($product)


	<div class="product-info">
		@foreach($product->info() as $key => $info)
		<div class="data-line">	
			<div class="label">{{$key}}:</div>
			<div class="value">{{$info}}</div>
		</div>	
		@endforeach
		{{$product->howManySoldIn()}}
	</div>
	@endif
@stop