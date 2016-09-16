@extends('layouts.users.default')

@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo ucfirst($user->user_name) ?> | 
            <small>Change Password</small>
        </h1>
    </section>

    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Change Password</li>
    </ol>

    <section class="content">
        <div class="col-md-6">

            @if( Session::get('msg') )
                <div class="alert alert-{{ Session::get('error') ? 'danger':'info' }}">
                    <span class="msg">{{ Session::get('msg')}}</span>
                </div>
            @endif
        
            {!! Form::open( array('url'=>'update/password', 'id'=>'form-change-password', 'method'=>'post') ) !!}
                <!-- text input -->
                <div class="form-group">
                    <label>Current Password:</label>
                    <input type="password" class="form-control" name="user_current_password" value="" placeholder="Current Password">
                </div>

                <div class="form-group">
                    <label>New Password:</label>
                    <input type="password" class="form-control" name="user_new_password" value="" placeholder="New Password">
                </div>

                <div class="form-group">
                    <label>Confirm Password:</label>
                    <input type="password" class="form-control" name="user_new_password_confirmation" value="" placeholder="Confirm Password">
                </div>

                <div class="info-msg" style="display: none">
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <span class="msg"></span>
                    </div>
                    <div class="alert alert-success">
                        <strong>Success!</strong> <span class="msg"></span>
                    </div>
                </div>

                <input type="submit" class="btn btn-primary submit" value="Update Password" data-svalue="Updating password" />
            </form>
        </div>
    </section>
@endsection