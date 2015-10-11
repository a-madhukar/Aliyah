@extends('app')

@section('content')
	<div class="container">
		<h2>Appointments</h2>
		<hr>
	<div class="container-fluid">
		<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#newAppointment">
			New Appointment
		</button>
	</div>
	

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#today" aria-controls="today" role="tab" data-toggle="tab">Today's Appointments</a></li>
    <li role="presentation"><a href="#upcoming" aria-controls="upcoming" role="tab" data-toggle="tab">Upcoming</a></li>
    <li role="presentation"><a href="#available" aria-controls="available" role="tab" data-toggle="tab">Available</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content" style="margin-top:20px;">
    <div role="tabpanel" class="tab-pane active" id="today">
		<div class="container-fluid">
			@if(count($todays))
				<ol>
					@foreach($todays as $_today)
						<li> 
							<p style="text-transform:capitalize;">
								<span><strong> {{$_today->first_name}}</strong></span>
								<span><strong> {{$_today->last_name}}</strong></span>
								<span>at</span>
								<span><strong> {{$_today->appoint_time}}</strong></span>
							</p>
							<p><a href="/medical/history/{{$_today->user_id}}/{{$_today->booking_id}}">View Medical Profile</a></p>
						</li>
					@endforeach
				</ol>				
			@else
				<p>You have no appointments today!</p>
			@endif
		</div>
    </div>
    <div role="tabpanel" class="tab-pane" id="upcoming">
		<div class="container-fluid">
				@if(count($upcomings))
				<ol>
					@foreach($upcomings as $_upcoming)
						<li> 
							<p style="text-transform:capitalize;">
								<span><strong> {{$_upcoming->first_name}}</strong></span>
								<span><strong> {{$_upcoming->last_name}}</strong></span>
							</p>
							<p>
								<span><strong>Date:</strong></span>
								<span> {{$_upcoming->appoint_date}}</span>
							</p>
							<p>
								<span><strong>Time:</strong></span>
								<span> {{$_upcoming->appoint_time}}</span>
							</p>
						</li>
					@endforeach
				</ol>				
			@else
				<p>You have no upcoming appointments!</p>
			@endif
		</div>
    </div>
    <div role="tabpanel" class="tab-pane" id="available">
    	<div class="container-fluid">
    		@if(count($availables))
				<ol>
					@foreach($availables as $_available)
						<li> 
							<p>
								<span><strong>Date:</strong></span>
								<span> {{$_available->appoint_date}}</span>
							</p>
							<p>
								<span><strong>Time:</strong></span>
								<span> {{$_available->appoint_time}}</span>
							</p>
						</li>
					@endforeach
				</ol>				
			@else
				<p>You have no available slots!</p>
			@endif
    	</div>
    </div>
 </div>

</div>
	
		<!--Modal for new appointment-->
		<div class="modal fade bs-example-modal-sm" id="newAppointment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModal Label">Add Appointment</h4>
					</div>
					<div class="modal-body">
						<div class="container-fluid">
						<form action="{{url('doctor/appointment')}}" method="POST">
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group">
								<label>Date</label>
								<input name="appoint_date" type="date" class="form-control">
							</div>
							<div class="form-group">
								<label>
									Time
								</label>
								<input name="appoint_time" type="time" class="form-control">
								
							</div>
						</div>
					</div>
					<div class="modal-footer">
							<button type="submit" class="btn btn-primary center-block">Add Slot</button>
					</div>
							</form>
				</div>
			</div>
		</div>
	</div>
@stop