@extends('layouts.users.default')

@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo ucfirst($user->user_name) ?> | 
            <small>Update Profile</small>
        </h1>
    </section>
    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">My Profile</li>
    </ol>

    @if(Session::has('flash_notice'))
        <div class="info-msg">
            <div class="alert alert-success">
                <strong>Succes!</strong> <span class="msg">{{ Session::get('flash_notice') }}</span>
            </div>
        </div>
    @endif

    @if(Session::has('flash_error'))
        <div class="info-msg" >
            <div class="alert alert-danger">
                <strong>Error!</strong> <span class="msg">{{ Session::get('flash_error') }}</span>
            </div>
        </div>
    @endif


    <section class="content">
        <div class="col-md-6">
            {!! Form::open( array('url'=>'edit/profile', 'class'=>'form-signin', 'id'=>'form-edit-profile', 'method'=>'post') ) !!}

                @if( Session::get('msg') )
                    <div class="alert alert-{{ Session::get('error') ? 'danger':'info' }}">
                        <span class="msg">{{ Session::get('msg')}}</span>
                    </div>
                @endif

                <!-- text input -->
                <!-- text input -->
                <div class="form-group clearfix">
                    <div class="col-xs-12 no-padding">
                        <label>Email:</label>
                    </div>
                    <div class="col-xs-9 no-padding">
                        <input type="text" class="form-control" name="user_email" value="<?php echo ($user->user_email) ?>" disabled="disabled">
                    </div>
                    <div class="col-xs-3" style="padding-top:5px">
                        <a href="{{ BASE_URL }}/edit/email">change email</a>
                    </div>
                </div>

                <div class="form-group">
                    <label>First Name:</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="user_firstname" value="<?php echo $user->user_firstname ? ucfirst($user->user_firstname) : "" ?>" placeholder="Enter your First Name" required>
                </div>

                <div class="form-group">
                    <label>Last Name:</label> <span class="text-danger">*</span>
                    <input type="text" class="form-control" name="user_lastname" value="<?php echo $user->user_lastname ? ucfirst($user->user_lastname) : "" ?>" placeholder="Enter your Last Name" required>
                </div>

                <div class="form-group">
                    <label>Birth Date:</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="user_birthdate" value="<?php echo $user->user_birthdate ? date("m/d/Y", strtotime($user->user_birthdate)) : "" ?>" placeholder="MM/DD/YYYY" required>
                </div>

                <div class="form-group">
                    <label>Phone:</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="user_phone" value="<?php echo $user->user_phone? ucfirst($user->user_phone) : "" ?>" required>
                </div>
                
                @if(Auth::user()->user_type == "organizer")
                    <div class="form-group">
                        <label>Organizer Website:</label>
                        <input type="text" class="form-control" name="user_website" value="<?php echo $user->website ? $user->website : "" ?>" placeholder="www.website.com">
                    </div>
                @endif

                <div class="form-group">
                    <label>Gender:</label><span class="text-danger">*</span>
                    <select class="form-control" name="user_gender">
                    <option>Select Gender</option>
                       @foreach( array('male', 'female') as $gender)
                           <option value="{{$gender}}" <?php echo $user->user_gender == $gender ? 'selected' : '' ?> >{{ ucfirst($gender) }}</option>
                       @endforeach
                    </select>
                </div>

                <input type="hidden" name="user_id" value="{{$user->user_id}}">

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
                <input type="submit" class="btn btn-primary submit" value="Update Profile" data-svalue="Updating profile" />

            </form>
            
        </div>
    </section>
@endsection