@extends('layouts.front')


@section('content')
<div class="container">
	{!! Form::open( array('action' => 'LoginController@index', 'class'=>'form-signin', 'id'=>'form-login', 'method'=>'post') ) !!}
	    <h2 class="form-login-heading">Employee Login</h2>
	    <label for="inputEmail" class="sr-only">Email address</label>
	    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
	    <label for="inputPassword" class="sr-only">Password</label>
	    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>

	    <div class="info-msg" style="display: none">
			<div class="alert alert-danger">
			    <strong>Error!</strong> <span class="msg"></span>
			</div>
			<div class="alert alert-success">
			    <strong>Success!</strong> <span class="msg"></span>
			</div>
		</div>

		@if( Session::get('msg') )
			<div class="alert alert-{{ Session::get('error') ? 'danger':'info' }}">
			    <span class="msg">{{ Session::get('msg')}}</span>
			</div>
		@endif

	    <input data-svalue="Logging in..." type="submit" value="Login" class="btn btn-lg btn-primary btn-block submit site-theme-bg" style="margin-right: 15px;" />

	    
	{!! Form::close() !!}

	@if(Session::has('flash_error'))
	    <div id="flash_error">{{ Session::get('flash_error') }}</div>
	@endif

</div> 
@endsection