@extends('layouts.pages')

@section('content')
	<div class="container main-wrap home">

		<div class="col-xs-12 text-center">
			<h2 style ="text-align:left;font-size: 30px;">{{$page_title}}</h2>
		</div>
		<div class="col-md-10">

			<div class="col-md-4">

				<h2>New User</h2>

				<p>You can create an account later</p>

				{!! Form::open( array('url' => '/event/signup/'.$event->id.'/'.$product->id, 'class'=>'form-login', 'id'=>'event-register-new-user', 'method'=>'post') ) !!}

					<input type="email" name="user_email" id="email" class="form-control" placeholder="Email Address">
					
					<input type="checkbox" name="participant_newsletter" id="newsletter" value="1"> Subscribe to our newsletter

					<input type="hidden" name="user_type" value="participant">

					@if( Session::get('msg') )
						<div class="alert alert-{{ Session::get('error') ? 'danger':'info' }}">
						    <span class="msg">{{ Session::get('msg')}}</span>
						</div>
					@endif

					<input type="submit" data-svalue="Please wait..." value="Create an account" class="btn btn-lg btn-primary btn-block submit">

				</form>

			</div>

			<div class="col-md-6">

				{!! Form::open( array('action' => 'UsersController@login', 'class'=>'form-login', 'id'=>'form-login', 'method'=>'post') ) !!}
				    <input type="hidden" name="event_id" value="{{$event_id}}" />
				    <input type="hidden" name="product_id" value="{{$product_id}}" />
				    <h2 class="form-login-heading">Login</h2>
				    <label for="inputEmail" class="sr-only">Email address</label>
				    <input type="email" name="user_email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
				    <label for="inputPassword" class="sr-only">Password</label>
				    <input type="password" name="user_password" id="inputPassword" class="form-control" placeholder="Password" required>

				    	<input type="hidden" name="event_id" value="{{$event->id}}">

				    <div class="info-msg" style="display: none">
						<div class="alert alert-danger">
						    <a href="#" class="close" data-dismiss="alert">&times;</a>
						    <strong>Error!</strong> <span class="msg"></span>
						</div>
						<div class="alert alert-success">
						    <a href="#" class="close" data-dismiss="alert">&times;</a>
						    <strong>Success!</strong> <span class="msg"></span>
						</div>
					</div>
					
				    <input data-svalue="Logging in..." type="submit" value="Login" class="btn btn-lg btn-primary btn-block submit site-theme-bg" style="margin-right: 15px;" />
				    <div class="row" style="padding: 20px 10px;">

				    </div>
				    
				    <p class="text-center">OR</p>
				    <a href="{{ BASE_URL }}/users/fbauth" class="btn btn-lg btn-block btn-social btn-primary">
			            <i class="fa fa-facebook"></i> Login with Facebook
			        </a>

			        <a href="{{ BASE_URL }}/users/gauth" class="btn btn-lg btn-block btn-social btn-google-plus btn-danger">
			            <i class="fa fa-google-plus"></i> Login with Google
			        </a>
			  

				{!! Form::close() !!}

			</div>

		</div>

		<div class="data">

			<div class="why">


			</div>
		</div>
	</div>
@endsection