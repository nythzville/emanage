@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <small>{{ ucwords($emp->firstname.' '.$emp->lastname) }} </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/employee/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
            <li>{{ ucwords($emp->firstname.' '.$emp->lastname) }} </li>
            <li class="active">Apply Leave</li>
        </ol>
    </section>

    @if((Session::has('flash_message')) && (Session::get('flash_message'))=="success")
        <div class="info-msg">
            <div class="alert alert-success">
                <strong>Succes!</strong> <span class="msg">form has been succesfully submitted.</span>
            </div>
        </div>
    @endif

    @if((Session::has('flash_message')) && (Session::get('flash_message'))=="error")
        <div class="info-msg" >
            <div class="alert alert-danger">
                <strong>Error!</strong> <span class="msg">Invalid input.</span>
            </div>
        </div>
    @endif


    <section class="content clearfix">

    	@include('includes.dashboard.employee.manage-employee-menu')
    	
        <div class="col-md-9">
            <!-- //<form action=" {{ url('employee/leaves' ) }} " method="post"  > -->
            {!! Form::open( array('url'=>'employee/leave_form', 'id'=>'form-create-leave', 'method'=>'post') ) !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Leave/Absent Form</h3>
                </div>
                <div class="box-body">
                    <div class="row">


                        <div class="form-group  col-md-6">
                            <label>First Name:</label>
                            <input type="text" disabled class="form-control" name="firstname" value="{{ $emp->firstname }}" placeholder="Enter your First Name" >
                        </div>

                        <div class="form-group  col-md-6">
                            <label>Last Name:</label>
                            <input type="text" disabled class="form-control" name="lastname" value="{{ $emp->lastname }}" placeholder="Enter your Last Name" >
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Start Date Date:</label><span class="text-danger"> *</span>
                            <input type="date" class="form-control" name="start_date" value="" >
                        </div>

                        <div class="form-group col-md-6">
                            <label>End Date:</label><span class="text-danger"> *</span>
                            <input type="date" class="form-control" name="end_date" value="" >
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Reason of Absence/Leave:</label><span class="text-danger"> *</span>
                            <textarea class="form-control" style="min-height: 80px" name="reasons"></textarea>
                        </div>
                    </div>

                     <div class="row">
                        <div class="form-group col-md-12">
                            <label>Note:</label>
                            <textarea class="form-control" style="min-height: 80px" name="note_for_absent"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <input type="text" class="form-control" name="no_of_days" value="" placeholder="Total Number of Days" >
                        </div>
                        <div class="form-group col-md-8 ">
                            <input type="submit" class="btn btn-primary submit pull-right" value="Submit" data-svalue="Submitting.." />
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
            </div>
        </form>
        </div>

    </section>
@endsection