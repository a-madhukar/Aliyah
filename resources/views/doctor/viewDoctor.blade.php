@extends('app')

@section('content')
<div class="container">
	<h2>Doctors</h2>
	<hr>
	@if(count($doctors))
	<ol>
		@foreach($doctors as $_doctor)
			<li>
				<h4>{{$_doctor->first_name}} <span>{{$_doctor->last_name}}</span></h4>
				<p><strong>Qualification: </strong><span>{{$_doctor->qualification}}</span></p>
				<p><strong>Specialism: </strong><span>{{$_doctor->specialism}}</span></p>
				<p> <a href="/admin/doctor/{{$_doctor->id}}/edit">Edit </a><span>|</span> <span> <a href="/admin/doctor/delete/{{$_doctor->id}}"> Delete </a></span></p>
			</li>
		@endforeach
	</ol>
	@else
		<p>No Doctors Have Been Created</p>
	@endif
</div>
@stop