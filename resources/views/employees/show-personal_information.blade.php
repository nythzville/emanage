@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <small>{{ ucwords($emp->firstname.' '.$emp->lastname) }} </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/employee/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
            <li>{{ ucwords($emp->firstname.' '.$emp->lastname) }}</li>
            <li class="active">Personal Information</li>
        </ol>
    </section>

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


    <section class="content clearfix">

    	@include('includes.dashboard.employee.manage-employee-menu')
    	
        <div class="col-md-9">
        	<div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Personal Information</h3>
                </div>
                <div class="box-body">

					
					<div class="row">
						<div class="form-group  col-md-6">
						 	<label>First Name:</label><span class="text-danger">*</span>
						 	<input type="text" disabled class="form-control" name="firstname" value="{{ $emp->firstname }}" placeholder="Enter your First Name" >
						</div>

						<div class="form-group  col-md-6">
						 	<label>Last Name:</label> <span class="text-danger">*</span>
						 	<input type="text" disabled class="form-control" name="lastname" value="{{ $emp->lastname }}" placeholder="Enter your Last Name" >
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label>Birth Date:</label><span class="text-danger">*</span>
							<input type="text" disabled class="form-control" name="birthdate" value="{{ date('m/d/Y', strtotime($emp->birthdate) ) }}" placeholder="MM/DD/YYYY" >
						</div>

						<div class="form-group col-md-6">
							<label>Gender:</label><span class="text-danger">*</span>
							<select class="form-control" name="gender" disabled>
								<option value="male" {{ $emp->gender == 'male' ? 'selected="selected"':'' }} >Male</option>
								<option value="female" {{ $emp->gender == 'female' ? 'selected="selected"':'' }}>Female</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="form-group  col-md-6">
						 	<label>Mobile no:</label><span class="text-danger">*</span>
						 	<input type="text" class="form-control" name="mobile_no" value="{{ $emp->mobile_no }}" disabled placeholder="+63 919 683 5445" >
						</div>

						<div class="form-group  col-md-6">
						 	<label>Home Phone No:</label> <span class="text-danger">*</span>
						 	<input type="text" disabled class="form-control" name="phone_no" value="{{ $emp->phone_no }}" placeholder="+63 33 330 3304" >
						</div>
					</div>

					<div class="form-group">
						<label>Complete Address:</label><span class="text-danger">*</span>
						<input disabled type="text" class="form-control" name="address" value="{{ $emp->address }}" >
					</div>
                </div><!-- /.box-body -->
                

                <div class="clearfix clear"></div>

                <div class="info-msg" style="display: none">
        			<div class="alert alert-danger">
        			    <strong>Error!</strong> <span class="msg"></span>
        			</div>
        			<div class="alert alert-success">
        			    <strong>Success!</strong> <span class="msg"></span>
        			</div>
        		</div>

            </div>
        </div> 
    </section>
@endsection