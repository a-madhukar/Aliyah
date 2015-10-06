@extends('app')

@section('content')
<div class="container">
	<h2>Edit Nurse</h2>
	<hr>
	@if(count($profile)==1)
	@foreach($profile as $profile)
		<form method="POST" class="form-horizontal" action="/admin/nurse/{{$profile->id}}">
			<input type="hidden" name="_method" value="PATCH">
			<input type="hidden" name="_token" value="{{csrf_token()}}">

					<!--First Name goes here--> 
			<div class="form-group">
				<label class="col-md-4 control-label">First Name</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="first_name" value="{{ $profile->first_name }}">
				</div>
			</div>

			<!--last_name  goes here--> 
			<div class="form-group">
				<label class="col-md-4 control-label">Last Name</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="last_name" value="{{ $profile->last_name }}">
				</div>
			</div>

			<!--address_line1  goes here--> 
			<div class="form-group">
				<label class="col-md-4 control-label">Address Line 1</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="address_line1" value="{{ $profile->address_line1 }}">
				</div>
			</div>

			<!--address_line2  goes here--> 
			<div class="form-group">
				<label class="col-md-4 control-label">Address Line 2</label>
				<div class="col-md-6">
						<input type="text" class="form-control" name="address_line2" value="{{ $profile->address_line2 }}">
				</div>
			</div>
								
			<!--city  goes here--> 
			<div class="form-group">
				<label class="col-md-4 control-label">City</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="city" value="{{ $profile->city }}">
				</div>
			</div>

			<!--state  goes here--> 
			<div class="form-group">
				<label class="col-md-4 control-label">State</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="state" value="{{ $profile->state }}">
				</div>
			</div>

							
			<!--country  goes here--> 
			<div class="form-group">
				<label class="col-md-4 control-label">Country</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="country" value="{{ $profile->country }}">
				</div>
			</div>

			<!--postcode  goes here--> 
			<div class="form-group">
				<label class="col-md-4 control-label">Post Code</label>
				<div class="col-md-6">
					<input type="number" class="form-control" name="postcode" value="{{ $profile->postcode }}">
				</div>
			</div>

			<!--phone  goes here--> 
			<div class="form-group">
				<label class="col-md-4 control-label">Phone</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="phone" value="{{ $profile->phone }}">
				</div>
			</div>

			<!--passport_no  goes here--> 
			<div class="form-group">
				<label class="col-md-4 control-label">Passport No</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="passport_no" value="{{ $profile->passport_no }}">
				</div>
			</div>

			<!--Ward of the doc-->
			<div class="form-group">
				<label class="col-md-4 control-label">
					Ward
				</label>
				<div class="col-md-6">
					<input type="text" class="form-control" name="ward" value="{{$profile->ward}}">
				</div>
			</div> 




			<!--The button for the form goes here--> 
			<div class="form-group">
				<div class="col-md-6 col-md-offset-4">
					<button class="btn btn-primary form-control">	Edit Nurse
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					</button>
				</div>
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

		</form>
		@endforeach
	@else
		<p>No Form to show</p>
	@endif
</div>
@stop