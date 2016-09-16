@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Employee | 
            <small>Create New </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Employee</a></li>
            <li class="active">Create New </li>
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


    {!! Form::open( array('url'=>'admin/employee/', 'id'=>'form-create-employee', 'method'=>'post') ) !!}
    <section class="content clearfix">
        <div class="col-md-12">
        	<div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Acount Details</h3>
                </div>
                <div class="box-body">
                	<div class="row">
						<div class="form-group col-lg-4">
						 	<label>Email:</label><span class="text-danger">*</span>
						 	<input type="text" class="form-control" name="email">
						</div>

						<div class="form-group col-md-4">
							<label>Account Type:</label><span class="text-danger">*</span>
							<select class="form-control" name="account_type">
								<option value="normal">Employee</option>
								<option value="admin">Admin</option>
								<option value="hr">Hr</option>
								<option value="owner">Owner</option>
							</select>
						</div>

						<div class="form-group col-lg-4">
						 	<label>ID No.:</label><span class="text-danger">*</span>
						 	<input type="text" class="form-control" name="identification">
						</div>
						<div class="form-group col-lg-6">
							<label>Password:</label><span class="text-danger">*</span>
							<input type="password" class="form-control" name="password">
						</div>
						<div class="form-group col-lg-6">
							<label>Confirm Password:</label><span class="text-danger">*</span>
							<input type="password" class="form-control" name="confirm_password">
						</div>

					</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
        	<div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Personal Information</h3>
                </div>
                <div class="box-body">

					
					<div class="row">
						<div class="form-group  col-md-6">
						 	<label>First Name:</label><span class="text-danger">*</span>
						 	<input type="text" class="form-control" name="firstname" value="" placeholder="Enter your First Name" >
						</div>

						<div class="form-group  col-md-6">
						 	<label>Last Name:</label> <span class="text-danger">*</span>
						 	<input type="text" class="form-control" name="lastname" value="" placeholder="Enter your Last Name" >
						</div>
					</div>

					<div class="row">
						<div class="form-group col-md-6">
							<label>Birth Date:</label><span class="text-danger">*</span>   MM/DD/YYYY
							<input type="text" class="form-control" name="birthdate" value="" placeholder="MM/DD/YYYY" >
						</div>

						<div class="form-group col-md-6">
							<label>Gender:</label><span class="text-danger">*</span>
							<select class="form-control" name="gender">
								<option value="male">Male</option>
								<option value="female">Female</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="form-group  col-md-6">
						 	<label>Mobile no:</label><span class="text-danger">*</span>
						 	<input type="text" class="form-control" name="mobile_no" value="" placeholder="+63 919 683 5445" >
						</div>

						<div class="form-group  col-md-6">
						 	<label>Home Phone No:</label> <span class="text-danger">*</span>
						 	<input type="text" class="form-control" name="phone_no" value="" placeholder="+63 33 330 3304" >
						</div>
					</div>

					<div class="form-group">
						<label>Complete Address:</label><span class="text-danger">*</span>
						<input type="text" class="form-control" name="address" value="" >
					</div>

                </div><!-- /.box-body -->
            </div>
        </div> 

        <div class="col-md-6">
        	<div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Work Details</h3>
                </div>
                <div class="box-body">
                	<div class="row">
						<div class="form-group  col-md-6">
						 	<label>Start Date:</label><span class="text-danger">*</span>   MM/DD/YYYY
						 	<input type="text" class="form-control" name="start_date" value="" placeholder="MM/DD/YYYY" >
						</div>

						<div class="form-group  col-md-6">
						 	<label>Status:</label><span class="text-danger">*</span>
							<select class="form-control" name="employment_status">
								<option>Employed</option>
								<option>Resigned</option>
							</select>
						</div>
					</div>

                	<div class="row">
						<div class="form-group  col-md-6">
						 	<label>Job Title:</label><span class="text-danger">*</span>
						 	<input type="text" class="form-control" name="job_title" value="" placeholder="Programmer" >
						</div>

						<div class="form-group  col-md-6">
						 	<label>Department:</label><span class="text-danger">*</span>
							<select class="form-control" name="department_id">
								@foreach ($departments as $department)
									<option value="{{ $department->id }}">{{ $department->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						 	<label>Employment Type:</label><span class="text-danger">*</span>
							<select class="form-control" name="employment_type">
								<option>Full Time</option>
								<option>Part Time</option>
								<option>Contractual</option>
								<option>Others</option>
							</select>
						</div>

					<div class="form-group">
						<label>Job Description:</label><span class="text-danger">*</span>
						<textarea class="form-control" style="min-height: 80px" name="job_description"></textarea>
					</div>

                </div>
            </div>
        </div>

        <div class="clearfix clear"></div>

        <div class="info-msg" style="display: none">
			<div class="alert alert-danger">
			    <strong>Error!</strong> <span class="msg"></span>
			</div>
			<div class="alert alert-success">
			    <strong>Success!</strong> <span class="msg"></span>
			</div>
		</div>
		
        <div class="action">
			<input type="submit" class="btn btn-primary submit pull-right" value="Submit" data-svalue="Updating profile" />
        </div>
        

    </section>
    </form>
@endsection