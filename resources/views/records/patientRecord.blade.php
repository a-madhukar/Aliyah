@extends('app')

@section('content')
	<div class="container">
		<h2>Medical History</h2>
		<hr>
		@if(Auth::check())
			@if(Auth::user()->type==2)
				<div class="container-fluid">
					<button type="button" class="pull-right btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Add Prescription</button>
				</div>
				<hr>
			@endif
		@endif
		@if(count($history))
			@foreach($history as $history)
				<div class="container-fluid">
					<h4>{{$history->sickness}}</h4>
					<p>{{$history->prescription}}</p>
					<p>{{$history->description}}</p>
					<p>{{$history->date}}</p>
				</div>
				<hr>
			@endforeach
		@else
			<p>There are no medical records to show for this patient</p>
		@endif
	</div>

	<!--Modal Goes Here-->
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	     	<div class="modal-header">
	     		<h4 class="modal-title">New Prescription</h4>
	     	</div>
	     	<form method="POST" action="{{url('prescription')}}"> 
	     		<input type="hidden" value="{{csrf_token()}}" name="_token"> 
	     		@if(Session::has('booking_id'))
	     			<input type="hidden" value="{{Session::get('booking_id')}}" name="booking_id"> 
	     		@endif
		     	<div class="modal-body">
		     		 <div class="form-group">
			            <label class="control-label">Sickness:</label>
			            <input type="text" class="form-control" name="sickness" placeholder="What's the ailment?">
			          </div>
			          <div class="form-group">
			            <label class="control-label">Prescription:</label>
			            <textarea class="form-control" rows=5 name="prescription" placeholder="What medicines should the patient take?"></textarea>
			          </div>
			          <div class="form-group">
			            <label class="control-label">Description:</label>
			            <textarea class="form-control" rows=5 name="description" placeholder="Any Special Instructions For The Patient?"></textarea>
			          </div>
			           @if (count($errors) > 0)
		<div class="alert alert-danger">
			<strong>Whoops!</strong> There were some problems with your input.<br><br>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
		     	</div>
	     	<div class="modal-footer">
	     		<button type="submit" class="btn btn-primary center-block">Add Prescription</button>

	     	</div>
		 </form>
	    </div>
	  </div>
	</div> 	
@stop