<!--First Name goes here--> 
	<div class="form-group">
		<label class="col-md-4 control-label">First Name</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}">
		</div>
	</div>

	<!--last_name  goes here--> 
	<div class="form-group">
		<label class="col-md-4 control-label">Last Name</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}">
		</div>
	</div>

	<!--address_line1  goes here--> 
	<div class="form-group">
		<label class="col-md-4 control-label">Address Line 1</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="address_line1" value="{{ old('address_line1') }}">
		</div>
	</div>

	<!--address_line2  goes here--> 
	<div class="form-group">
		<label class="col-md-4 control-label">Address Line 2</label>
		<div class="col-md-6">
				<input type="text" class="form-control" name="address_line2" value="{{ old('address_line2') }}">
		</div>
	</div>
						
	<!--city  goes here--> 
	<div class="form-group">
		<label class="col-md-4 control-label">City</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="city" value="{{ old('city') }}">
		</div>
	</div>

	<!--state  goes here--> 
	<div class="form-group">
		<label class="col-md-4 control-label">State</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="state" value="{{ old('state') }}">
		</div>
	</div>

					
	<!--country  goes here--> 
	<div class="form-group">
		<label class="col-md-4 control-label">Country</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="country" value="{{ old('country') }}">
		</div>
	</div>

	<!--postcode  goes here--> 
	<div class="form-group">
		<label class="col-md-4 control-label">Post Code</label>
		<div class="col-md-6">
			<input type="number" class="form-control" name="postcode" value="{{ old('postcode') }}">
		</div>
	</div>

	<!--phone  goes here--> 
	<div class="form-group">
		<label class="col-md-4 control-label">Phone</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
		</div>
	</div>

	<!--passport_no  goes here--> 
	<div class="form-group">
		<label class="col-md-4 control-label">Passport No</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="passport_no" value="{{ old('passport_no') }}">
		</div>
	</div>

	<!--ward of the doc-->
	<div class="form-group">
		<label class="col-md-4 control-label">
			Ward
		</label>
		<div class="col-md-6">
			<input type="text" class="form-control" name="ward" value="{{old('ward')}}">
		</div>
	</div> 

	<!--Email of the Doctor Goes Here-->
	<div class="form-group">
		<label class="col-md-4 control-label">Email</label>
		<div class="col-md-6">
			<input type="email" class="form-control" name="email" value="{{old('email')}}">
		</div>
	</div> 

	<!--The button for the form goes here--> 
	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<button class="btn btn-primary form-control">	{{$button_name}}
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
