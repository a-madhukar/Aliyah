@extends('app')

@section('content')
	<div class="container">
		<h2>Available Appointments for <span style="text-transform:capitalize;">Dr.{{$profile->first_name}}</span></h2>
		<hr>
		@if(count($appointments))
		<form action="{{url('appointment/make')}}" method="POST">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
			<table class="table">
				<thead>
					<tr>
						<th>Date</th>
						<th>Time</th>
						<th>Book</th>
					</tr>
				</thead>
				<tbody>
						@foreach($appointments as $_appointment)
							<tr>
								<td>{{$_appointment->appoint_date}}</td>
								<td>{{$_appointment->appoint_time}}</td>
								<td>
									<select name="booking[]">
										<option value="none">---</option>
										<option value="{{$_appointment->id}}">Book Now</option>
									</select>
								</td>
							</tr>
						@endforeach

				</tbody>
				</form>
			</table>	
			<button type="submit" class="btn btn-primary form-control">Book Appointment</button>


			@if(count($errors)>0)
				<div class="alert alert-danger" style="margin-top:20px;">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
			@endif
		@endif
	</div>	
@stop