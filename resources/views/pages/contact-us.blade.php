@extends('layouts.pages')

@section('content')
	<div class="container main-wrap home">
		
		<div class="col-xs-12 text-center">
			<h2 style ="font-size: 50px;">Let's begin our conversation</h2>
		</div>
		<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
			{!! Form::open( array('action' => 'PagesController@contact', 'class'=>'', 'method'=>'post') ) !!}

			<form id="freeform" name="a" method="post" action="http://www.raceit.com/">
				<div class="form-group">
					<input type="text" name="first_name" value="{{ Input::get('first_name') }}" class="form-control input-lg" placeholder="First name">
				</div>
				<div class="form-group">
					<input type="text" name="last_name" value="{{ Input::get('last_name') }}" class="form-control input-lg" placeholder="Last name">
				</div>
				<div class="form-group">
					<input type="email" name="email"  value="{{ Input::get('email') }}" class="form-control input-lg" placeholder="Your email address">
				</div>
				<div class="form-group">
					<select name="subject" class="form-control input-lg">
						<option value="Reason 1">Reason 1</option>
						<option value="Reason 2">Reason 2</option>
						<option value="Reason 3">Reason 3</option>
						<option value="Reason 4">Reason 4</option>
						<option value="Reason 5">Reason 5</option>
					</select>
				</div>
				<div class="form-group">
					<textarea name="message" class="form-control input-lg" rows="3" placeholder="How may we help you? :)">{{ Input::get('message') }}</textarea>
				</div>

				@if( isset($msg) && $msg )
					<div class="alert alert-{{ isset($error) && $error ? 'danger':'success' }}">
					    <a href="#" class="close" data-dismiss="alert">&times;</a>
					    <span class="">
					    	@if( isset($messages) && $messages && $error )
					    		@foreach( $messages as $key=> $value )
					    			<p>{{ $value[0] }}</p>
					    		@endforeach
					    	@endif
					    	@if( !$error )
					    		<p>{{ $msg }}</p>
					    	@endif
					    </span>
					</div>
				@endif

				<p class="text-center ss-last">
					<button type="submit" class="btn btn-lg btn-primary">Send Message</button>
				</p>
			</form>
		</div>
		
		<div class="data">

			<div class="why">
				
				
			</div>
		</div>
	</div>
@endsection