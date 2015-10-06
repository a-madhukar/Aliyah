@extends('app')

@section('content')
<div class="container"> 
	<h2>Specialists</h2>

	<hr>
@if(count($specialists))
	<ol>
		@foreach($specialists as $specialist)
		<li><a href="/appointment/get/{{$specialist->user_id}}"><h4>{{$specialist->first_name}} <span>{{$specialist->last_name}}</span></h4></a>
		<p><strong>Qualification : </strong><span>{{$specialist->qualification}}</span></p>
		<p><strong>Specialism : </strong></span>{{$specialist->specialism}}</span></p> </li>
	@endforeach
	</ol>	
@else 
	<p>No specialists have been added. Contact the admin</p>
@endif
</div>
@stop