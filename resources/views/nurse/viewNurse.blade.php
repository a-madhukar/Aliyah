@extends('app')

@section('content')
<div class="container">
	<h2>Nurses</h2>
	<hr>
	@if(count($nurses))
	<ol>
		@foreach($nurses as $_nurse)
			<li>
				<h4>{{$_nurse->first_name}} <span>{{$_nurse->last_name}}</span></h4>
				<p><strong>Ward: </strong><span>{{$_nurse->ward}}</span></p>
				<p> <a href="/admin/nurse/{{$_nurse->id}}/edit">Edit </a><span>|</span> <span> <a href="/admin/nurse/delete/{{$_nurse->id}}"> Delete </a></span></p>
			</li>
		@endforeach
	</ol>
	@else
		<p>No Nurses Have Been Created</p>
	@endif
</div>
@stop