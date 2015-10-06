@extends('app')

@section('content')
	<div class="container">
		<h2>Patient...</h2>
		<hr>
		@if(count($user))
			<ol>
			@foreach($user as $_user)
				<li style="text-transform:capitalize;">
					<h3>{{$_user->first_name}} <span> {{$_user->last_name}}</span></h3>
					<p><strong>Address Line 1:</strong> <span> {{$_user->address_line1}}</span></p>
					<p><strong>Address Line 2:</strong> <span> {{$_user->address_line2}}</span></p>
					<p><strong>City:</strong> <span> {{$_user->city}}</span></p>
					<p><strong>State: </strong> <span> {{$_user->state}}</span></p>
					<p><strong>Country:</strong> <span> {{$_user->country}}</span></p>
					<p><strong>Postcode:</strong> <span> {{$_user->postcode}}</span></p>
					<p><strong>Passport No:</strong><span> {{$_user->passport_no}}</span> </p>
					<p><a href="/admin/patient/history/{{$_user->id}}">Check Booking History</a></p>
				</li>
			@endforeach
			</ol>
		@else
			<p>No Results</p>
		@endif
	</div>
@stop