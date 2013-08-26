@section('contents')
	{{Form::model($product = new Products, array('route'=>array('api.products.store')))}}
	<div>
		{{Form::label('title','Title:')}}
		{{Form::text('title')}}
	</div>
	<div>
		{{Form::label('asin','Amazon ASIN:')}}
		{{Form::text('asin')}}
	</div>
	<div>
		{{Form::label('upc_isbn','UPC/ISBN:')}}
		{{Form::text('upc_isbn')}}
	</div>
	<div>
		{{Form::label('manufacturer_part_no','Manufacturer Part #:')}}
		{{Form::text('manufacturer_part_no')}}
	</div>
	<div>
		{{Form::label('description','Product Description:')}}
		{{Form::textarea('description')}}
	</div>
	<div>
		{{Form::label('brand','Brand:')}}
		{{Form::text('brand')}}
	</div>
	<div>
		{{Form::label('sku','Product SKU:')}}
		{{Form::text('sku')}}
	</div>
	<div>
		{{Form::submit('Submit')}}
	</div>
	{{Form::close()}}

	@if ($errors)
	<ul>
		@foreach($errors->all() as $message)
			<li>{{$message}}</li>
		@endforeach
	</ul>
	@endif
@stop