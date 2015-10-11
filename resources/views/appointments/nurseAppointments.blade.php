@extends('app')

@section('content')
	<div class="container">
		<h2>Today's Appointments</h2>
		<hr>
		  <!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
		  <li role="presentation" class="active"><a href="#today" aria-controls="today" role="tab" data-toggle="tab">Today's Appointments</a></li>
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
		</div>

	</div>
@stop