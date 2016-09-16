{!! Form::open( array('action' => 'UsersController@login', 'class'=>'form-login', 'id'=>'form-login', 'method'=>'post') ) !!}
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
	    <a href="{{ BASE_URL }}/users/fbauth" class="btn btn-lg btn-block btn-social btn-facebook">
            <i class="fa fa-facebook"></i> Login with Facebook
        </a>

        <a href="{{ BASE_URL }}/users/gauth" class="btn btn-lg btn-block btn-social btn-google-plus">
            <i class="fa fa-google-plus"></i> Login with Google
        </a>
  

	{!! Form::close() !!}