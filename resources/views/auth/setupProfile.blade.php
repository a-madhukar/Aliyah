@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h2>Step 2 </h2>
			<hr/> 
			<div class="panel panel-default" style="margin-bottom:50px;">
				<div class="panel-heading">
					Setup Your Profile
				</div>
				<div class="panel-body">
					<form action="{{url('/auth/profile')}}" method="POST" class="form-horizontal">
						<input type="hidden" value="{{csrf_token()}}" name="_token">
						
						@include('partials._profile',['button_name'=>'Setup Profile'])	
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop