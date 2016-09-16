@extends('layouts.default')

@section('content')
<div class="container main-wrap">
	{!! Form::open( array('action' => 'UsersController@recover_password', 'class'=>'form-login', 'id'=>'form-forgot-password-new', 'method'=>'post') ) !!}
	    <h2 class="form-login-heading">Enter New Password</h2>
	    <input type="password" name="user_password" class="form-control" placeholder="New Password" required autofocus>
	    <input type="password" name="user_password_confirmation" class="form-control" placeholder="Confirm New Password" required autofocus>
	    <div class="info-msg" style="display: none">
			<div class="alert alert-danger">
			    <strong>Error!</strong> <span class="msg"></span>
			</div>
			<div class="alert alert-success">
			    <strong>Success!</strong> <span class="msg"></span>
			</div>
		</div>
		<input name="reset_code" type="hidden" value="{{ $user_password_reset_code }}" />
		<input name="user_uid" type="hidden" value="{{ $user_uid }}" />

		<a href="{{ BASE_URL }}/login" class="btn btn-lg btn-block btn-social btn-facebook login" style="display: none">
            Sigin with new password
        </a>
		<input data-svalue="Please wait.." value="Save" class="btn btn-lg btn-primary btn-block submit" type="submit">
	{!! Form::close() !!}

	@if(Session::has('flash_error'))
	    <div id="flash_error">{{ Session::get('flash_error') }}</div>
	@endif
</div>
@endsection