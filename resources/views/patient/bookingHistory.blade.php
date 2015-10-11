@extends('app')

@section('content')
	<div class="container">
		<h2>Booking History</h2>
		<hr>
		@if(count($history))
			<ol>
				@foreach($history as $_history)
					<li style="text-transform:capitalize;">
						 <p>
						 	<strong>Appointment With </strong> <span> Dr.{{$_history->first_name}} </span> <span> {{$_history->last_name}}</span>
						 </p>
						<p>
							<strong>On: </strong> <span> {{$_history->appoint_date}}</span>
						</p>
						<p>
							<strong>At: </strong> <span> {{$_history->appoint_time}}</span>
						</p>
					 </li>
				@endforeach
			</ol>
		@else
			@if(Auth::user()->type==4)
				<p>You haven't made any bookings yet.</p>
			@endif
			<p>The patient hasn't booked any appointments</p>
		@endif
	</div>
@stop