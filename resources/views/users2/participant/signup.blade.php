@extends('layouts.pages')

@section('content')
	<div class="container main-wrap home">

		<div class="col-xs-12 text-center">
			<h2 style ="font-size: 50px;">{{$page_title}}</h2>
		</div>
		<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
								{!! Form::open(array('action' => 'UsersController@store', 'id'=>'sign-up-form', 'class'=>'form-signup')) !!}
						<h2>Sign Up<small> It's free!</small></h2>
							    <label for="user_name" class="sr-only">Full Name</label>
								<input type="text" name="user_name" id="name" class="form-control" placeholder="Full Name">

							    <label for="user_email" class="sr-only">Email address</label>
								<input type="email" name="user_email" id="email" class="form-control" placeholder="Email Address">

							    <label for="user_password" class="sr-only">Password</label>
								<input type="password" name="user_password" id="password" class="form-control" placeholder="Password">

							    <label for="user_password_confirmation" class="sr-only">Retype Password</label>
								<input type="password" name="user_password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">

								<input type="hidden" name="user_type" value="participant">

								@if( Session::get('msg') )
									<div class="alert alert-info">
									    <a href="#" class="close" data-dismiss="alert">&times;</a>
									    <span class="msg">{{ Session::get('msg')}}</span>
									</div>
								@endif

							    <div class="info-msg" style="display: none">
									<div class="alert alert-danger">
									    <strong>Error!</strong> <span class="msg"></span>
									</div>
									<div class="alert alert-success">
									    <strong>Success!</strong> <span class="msg"></span>
									</div>
								</div>

								<input type="submit" data-svalue="Please wait..." value="Create an account" class="btn btn-lg btn-primary btn-block submit">

						        <div class="foot">
						        	<a href="{{ BASE_URL }}/login">
						        		Already have an account?
							        </a>
						        </div>
							</form>
			</form>
		</div>

		<div class="data">

			<div class="why">


			</div>
		</div>
	</div>
@endsection