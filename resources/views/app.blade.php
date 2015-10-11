<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Project Health</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('/css/custom.css')}}"> 

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				@if(Auth::check())
					@if(Auth::user()->type==1)
						<a class="navbar-brand" href="{{url('admin/doctor')}}">Project Health</a>
					@elseif(Auth::user()->type==2)
						<a class="navbar-brand" href="{{url('doctor/appointment')}}">Project Health</a>
					@elseif(Auth::user()->type==3)
						<a class="navbar-brand" href="{{url('nurse/appointments')}}">Project Health</a>
					@elseif(Auth::user()->type==4)
						<a class="navbar-brand" href="{{url('patient/history/booking')}}">Project Health</a>
					@endif
				@else
					<a class="navbar-brand" href="{{url('/')}}">Project Health</a>
				@endif
				
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
				  <!--	<li><a href="{{ url('/') }}">Home</a></li> -->
				  @if(Auth::check())
					@if(Auth::user()->type==1)
						 <li class="dropdown">
					          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Doctors <span class="caret"></span></a>
					          <ul class="dropdown-menu">
					            <li><a href="{{url('admin/doctor/create')}}">New Doctor</a></li>
					            <li role="separator" class="divider"></li>
								<li><a href="{{url('admin/doctor')}}">View Doctors</a></li>			            
					          </ul>
							</li> 

							 <li class="dropdown">
					           <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Nurses <span class="caret"></span></a>
					          <ul class="dropdown-menu">
					            <li><a href="{{url('admin/nurse/create')}}">New Nurse</a></li>
					            <li role="separator" class="divider"></li>
								<li><a href="{{url('admin/nurse')}}">View Nurses</a></li>			            
					          </ul>
					        </li>

					       <li><a href="#" data-toggle="modal" data-target=".bs-example-modal-sm">Search Patient</a></li>

					@elseif(Auth::user()->type==2)
						<li><a href="{{url('doctor/appointment')}}">Appointments</a></li>
					@elseif(Auth::user()->type==3)


				  	@elseif(Auth::user()->type==4)
				  		<li><a href="#" data-toggle="modal" data-target=".bs-example-modal-sm">Book</a></li>
				  		<li><a href="{{url('patient/history/view')}}">Medical History</a></li>
				  	@endif
				  @endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						<li><a href="{{ url('/auth/signup') }}">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts 
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script> -->

@if(Auth::check())
	@if(Auth::user()->type==1)
		<!--Search Patient Modal-->
		<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" arialabelledby="searchPatientModal">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Search Patient</h4>
					</div>
					<form action="{{url('admin/search/patient')}}" method="GET">
						<div class="modal-body">
							<div class="form-group">

								<input type="text" placeholder="Search By First Name" name="first_name" class="form-control">
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-primary center-block" type="submit">
								Find
							</button>
						</div>
					</form>	
				</div>
			</div>
		</div> 
	@endif
@endif

	

@if(Auth::check())
	@if(Auth::user()->type==4)
	<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" arialabelledby="mySmallModalLabel"> 
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Find Specialist</h4>
					<form action="{{url('search/specialist')}}" method="GET">
						<div class="modal-body">
							<div class="form-group">
								<label class="control-label">Specialist</label>
								@if(Session::has('specialismList'))
									@if(count(Session::get('specialismList')))
										<select name="specialisms" id="" class="form-control">
											<option value="all">All</option>
											@foreach(Session::get('specialismList') as $_specialism)
												<option value="{{$_specialism}}">{{$_specialism}}</option>
											@endforeach
										</select>
									@else
										<p>No specialists available. Contact the admin</p>
									@endif
								@endif
							</div>
						</div>
						<div class="modal-footer">
							@if(count(Session::get('specialismList')))
								<button class="btn btn-primary center-block" type="submit">
									Find
								</button>
							@else
								<button class="btn btn-primary center-block" data-dismiss="modal">
									Find
								</button>
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>	
	</div>	
	@endif
@endif

	<!--Scripts-->
	<script src="{{asset('/js/jquery.js')}}"></script>
	<script src="{{asset('/js/bootstrap.js')}}"></script>
</body>
</html>
