@extends('app')

@section('content')
	<div class="container">
		<h2>Edit Prescription</h2>
		<form method="POST" action="{{url('prescription/'.$prescription->id)}}"> 
	     		<input type="hidden" value="{{csrf_token()}}" name="_token"> 
	     		<input type="hidden" name="_method" value="PATCH">
	     		@if(Session::has('booking_id'))
	     			<input type="hidden" value="{{Session::get('booking_id')}}" name="booking_id"> 
	     		@endif
	      		 <div class="form-group">
			         <label class="control-label">Sickness:</label>
			         <input type="text" class="form-control" name="sickness" placeholder="What's the ailment?" value="{{$prescription->sickness}}">
			     </div>
			     <div class="form-group">
			        <label class="control-label">Prescription:</label>
			        <textarea class="form-control" rows=5 name="prescription" placeholder="What medicines should the patient take?">{{$prescription->prescription}}</textarea>
			    </div>
			    <div class="form-group">
			        <label class="control-label">Description:</label>
			        <textarea class="form-control" rows=5 name="description" placeholder="Any Special Instructions For The Patient?">{{$prescription->description}}</textarea>
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
	     		<button type="submit" class="btn btn-primary center-block">Edit Prescription</button>
		 </form>
	</div>
@stop