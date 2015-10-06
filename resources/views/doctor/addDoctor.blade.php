@extends('app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Add Doctor
					</div>
					<div class="panel-body">
						<form method="POST" action="{{url('admin/doctor')}}" class="form-horizontal">
							<input type="hidden" name="_token" value={{csrf_token()}}>
							@include('partials._doctor',['button_name'=>'Add Doctor'])
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop