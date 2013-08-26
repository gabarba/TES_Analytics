@section('contents')

	@if($customers)
		<table class="data-table">
			<tr>
				<th>Name</th>
			</tr>
			@foreach($customers as $customer)
				<tr>
					<td>{{$customer}}</td>
				</tr>
			@endforeach
		</table>
	@endif
@stop