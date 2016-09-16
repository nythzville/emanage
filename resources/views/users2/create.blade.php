@extends('layouts.front')

@section('content')
<div class="container main-wrap">
	{!! Form::open(array('action' => 'UsersController@store', 'id'=>'sign-up-form', 'class'=>'form-signup')) !!}
		<h2>Sign Up<small> Event Organizer!</small></h2>
	    <label for="user_name" class="sr-only">Full Name</label>
		<input type="text" name="user_firstname" id="firstname" class="form-control" placeholder="First Name">

		<input type="text" name="user_lastname" id="lastname" class="form-control" placeholder="Last Name">

	    <label for="user_email" class="sr-only">Email address</label>
		<input type="email" name="user_email" id="email" class="form-control" placeholder="Email Address">

	    <label for="user_password" class="sr-only">Password</label>
		<input type="password" name="user_password" id="password" class="form-control" placeholder="Password">

	    <label for="user_password_confirmation" class="sr-only">Retype Password</label>
		<input type="password" name="user_password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password">

		<input type="checkbox" name="user_newsletter" id="newsletter" value="1" style="margin-top:15px;"><span style="font-size:16px;"> Subscribe to our newsletter</span>

		{{-- <input type="hidden" name="user_type" value="organizer"> --}}

		<select name="user_type" class="form-control">
			<option value="organizer">Organizer</option>
			<option value="participant">Participant</option>
		</select>


		@if( Session::get('msg') )
			<div class="alert alert-info">
			    <a href="#" class="close" data-dismiss="alert">&times;</a>
			    <span class="msg">{{ Session::get('msg')}}</span>
			</div>
		@endif

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

		<input type="submit" data-svalue="Please wait..." value="Create an account" class="btn btn-lg btn-primary btn-block submit">

        <div class="foot">
        	<a href="{{ BASE_URL }}/login">
        		Already have an account?
	        </a>
        </div>
	</form>
</div>
@endsection