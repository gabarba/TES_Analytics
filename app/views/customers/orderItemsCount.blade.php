@section('contents')

	@if($customers)
		<table class="data-table">
			<tr>
				<th>Name</th>
				<th>Id</th>
			</tr>
			@foreach($customers as $customer)
				<tr>
					<td>{{$customer['name']}}</td>
					<td>{{link_to_action('CustomersController@show',$customer['id'],array($customer['id']),array('target'=>'_blank'))}}</td>
				</tr>
			@endforeach
		</table>

	@endif
@stop