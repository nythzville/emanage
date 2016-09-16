@extends('layouts.default')

@section('content')
<div class="container main-wrap">
	{!! Form::open( array('action' => 'UsersController@recover_password_submit', 'class'=>'form-login', 'id'=>'form-forgot-password', 'method'=>'post') ) !!}
	    <h2 class="form-login-heading">Enter Email Address</h2>
	    <label for="inputEmail" class="sr-only">Email address</label>
	    <input type="email" name="user_email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
	    <div class="info-msg" style="display: none">
			<div class="alert alert-danger">
			    <strong>Error!</strong> <span class="msg"></span>
			</div>
			<div class="alert alert-success">
			    <strong>Success!</strong> <span class="msg"></span>
			</div>
		</div>

		<input data-svalue="Please wait.." value="Recover" class="btn btn-lg btn-primary btn-block submit" type="submit">
        <div class="foot text-center" style="padding: 20px 30px;">
	    	<a href="{{ BASE_URL }}/login">
	    		Login
	        </a>
	    </div>
	{!! Form::close() !!}

	@if(Session::has('flash_error'))
	    <div id="flash_error">{{ Session::get('flash_error') }}</div>
	@endif
</div>
@endsection