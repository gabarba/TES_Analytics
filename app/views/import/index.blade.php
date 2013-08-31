@section('contents')

@if($hasFile)
	File Recieved and Import Process Started
	
@endif
	<h1>Import CSV File </h1>
<div class="row">
	<div class="col-md-3">
	{{Form::open(array('url'=>'import','files'=>true))}}
	<div class="form-group">
		{{Form::label('delimiter', 'Delimiter')}}
		{{Form::text('delimiter','^', array('class'=>'form-control'))}}
	</div>
	<div class="form-group">
		{{Form::label('enclosure', 'Enclosure')}}
		{{Form::text('enclosure','|', array('class'=>'form-control'))}}
	</div>
	<div class="form-group">
		{{Form::label('csv_import', 'Import CSV')}}
		{{Form::file('csv_import',array('class'=>'form-control'))}}
	</div>
		{{Form::submit('Import')}}
	{{Form::close()}}
	</div>
</div>
@stop