@extends('app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Add Nurse
					</div>
					<div class="panel-body">
						<form method="POST" action="{{url('admin/nurse')}}" class="form-horizontal">
							<input type="hidden" name="_token" value={{csrf_token()}}>
							@include('partials._nurse',['button_name'=>'Add Nurse'])
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop