@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Employee | 
            <small>{{ ucwords($emp->firstname.' '.$emp->lastname) }} </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Employee</a></li>
            <li>{{ ucwords($emp->firstname.' '.$emp->lastname) }}</li>
            <li class="active">Personal Information</li>
        </ol>
    </section>

    <!-- @include('includes.dashboard.flash-message') -->
    


    {!! Form::open( array('url'=>'admin/employee/'.$emp->id.'/update/personal_information', 'id'=>'form-update-personal-information', 'method'=>'post') ) !!}
    <section class="content clearfix">

        @include('includes.dashboard.manage-employee-menu')
        
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Personal Information</h3>
                </div>
                <div class="box-body">

                    
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>First Name:</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="firstname" value="{{ $emp->firstname }}" placeholder="Enter your First Name" >
                        </div>

                        <div class="form-group  col-md-6">
                            <label>Last Name:</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control" name="lastname" value="{{ $emp->lastname }}" placeholder="Enter your Last Name" >
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Birth Date:</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="birthdate" value="{{ date('m/d/Y', strtotime($emp->birthdate) ) }}" placeholder="MM/DD/YYYY" >
                        </div>

                        <div class="form-group col-md-6">
                            <label>Gender:</label><span class="text-danger">*</span>
                            <select class="form-control" name="gender">
                                <option value="male" {{ $emp->gender == 'male' ? 'selected="selected"':'' }} >Male</option>
                                <option value="female" {{ $emp->gender == 'female' ? 'selected="selected"':'' }}>Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Mobile no:</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="mobile_no" value="{{ $emp->mobile_no }}" placeholder="+63 919 683 5445" >
                        </div>

                        <div class="form-group  col-md-6">
                            <label>Home Phone No:</label> <span class="text-danger">*</span>
                            <input type="text" class="form-control" name="phone_no" value="{{ $emp->phone_no }}" placeholder="+63 33 330 3304" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Complete Address:</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="address" value="{{ $emp->address }}" >
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
                
                <div class="action">
                    <input type="submit" class="btn btn-primary submit pull-right" value="Update Personal Information" data-svalue="Updating personal information..." />
                </div>
            </div>
        </div> 
    </section>
    </form>
@endsection