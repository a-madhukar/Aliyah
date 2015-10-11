@extends('app')

@section('content')
	<div class="container">
		<h2>Preview Prescription</h2>
		<hr>
		<p><strong>Sickness:</strong> <span> {{$prescription->sickness}}</span></p>
		<p><strong>Prescription:</strong> <span> {{$prescription->prescription}}</span></p>
		<p><strong>Description:</strong> <span> {{$prescription->description}}</span></p>
		<p>
			<span><a href="/prescription/{{$prescription->id}}/edit">Edit Prescription</a></span>
			<span> | </span>
			<span><a href="/prescription/delete/{{$prescription->id}}">Delete Prescription</a></span></p>
		<p><a href="{{url('doctor/appointment')}}">Back To Home</a></p>
	</div>
@stop