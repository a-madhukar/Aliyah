@extends('app')

@section('content')
		<!--Header section--> 
	<header>
		<div class="jumbotron">
		</div> 	
	</header>

	<section id="section1">
		<div class="container">
			<div class="row padding" style="margin-top:15%;">
				<div class="col-md-4">
					<h3 class="text-center"> 
						Book Consultation
					</h3>
				</div>
				<div class="col-md-4">
					<h3 class="text-center">
						Track Your Health
					</h3>
				</div>
				<div class="col-md-4">
					<h3 class="text-center">
						Find Specialists
					</h3>
				</div>
			</div>
		</div>
	</section>


	<section id="section2">
		<div class="container">
			
		</div>
	</section>


	<section id="section3">	
		<div class="container">
			<h2 class="padding">Drop Us A Message!</h2>
			<div class="container-fluid padding">
				<form class="form-horizontal">
					<div class="form-group">
						<label class="label-control">Email</label>
						<input type="email" class="form-control" placeholder="johndoe@example.com" name="_email">
					</div>
					<div class="form-group">
						<label class="label-control">Message</label>
						<textarea name="message" class="form-control" cols="30" rows="10" placeholder="What's on your mind?"></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-primary form-control" type="submit">Send</button>
					</div>
				</form>
			</div>
		</div>
	</section>

	<footer> 
		<div class="container">
			<p class="padding">&copy; Aliyah <br/>2015 <br/><a href="#top">Back To The Top</a></p>
		</div>
	</footer> 
@stop