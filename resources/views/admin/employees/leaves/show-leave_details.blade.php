@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
     <section class="content-header">
        <h1>Leaves |
            <small>View</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="active">Leave Management</li>
            <li class="active">View</li>
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

    	@include('includes.dashboard.manage-employee-menu')

        <div class="col-md-9">
           
        {!! Form::open( array('url'=>'admin/leaves/'.$leave->id.'/update/leave_details', 'id'=>'form-update-leave-details', 'method'=>'post') ) !!}
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Leave/Absent Form</h3>
                </div>
                <div class="box-body">
                    <div class="row">


                        <div class="form-group  col-md-6">
                            <label>First Name:</label>
                            <input type="text" disabled class="form-control" name="firstname" value="{{ $leave->employee->firstname }}" placeholder="Enter your First Name" >
                        </div>

                        <div class="form-group  col-md-6">
                            <label>Last Name:</label>
                            <input type="text" disabled class="form-control" name="lastname" value="{{ $leave->employee->lastname }}" placeholder="Enter your Last Name" >
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Start Date Date:</label><span class="text-danger"> *</span>
                            <input type="date" class="form-control" name="start_date" value="{{ $leave->start_date }}" >
                        </div>

                        <div class="form-group col-md-6">
                            <label>End Date:</label><span class="text-danger"> *</span>
                            <input type="date" class="form-control" name="end_date" value="{{ $leave->end_date }}" >
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Reason of Absence/Leave:</label><span class="text-danger"> *</span>
                            <textarea class="form-control" style="min-height: 80px" name="reasons">{{ $leave->reason_of_leave }}</textarea>
                        </div>
                    </div>

                     <div class="row">
                        <div class="form-group col-md-12">
                            <label>Note:</label>
                            <textarea class="form-control" style="min-height: 80px" name="note_for_absent">{{ $leave->note }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Number of Days:</label>
                            <input type="text" class="form-control" name="no_of_days" value="{{ $leave->no_of_days }}" placeholder="Total Number of Days" >
                        </div>
                        <div class="form-group col-md-6">
                            <label>Status: </label><span class="text-danger">*</span>
                            <select class="form-control" name="leave_status">
                                <!-- <option  value="{{ $leave->leave_status }}"> {{ $leave->leave_status }} - current status</option> -->
                                <option  value="PENDING" {{ $leave->leave_status == 'PENDING' ? 'selected="selected"': '' }}>PENDING</option>
                                <option  value="APPROVED" {{ $leave->leave_status == 'APPROVED' ? 'selected="selected"': '' }}>APPROVED</option>
                                <option  value="REJECTED" {{ $leave->leave_status == 'REJECTED' ? 'selected="selected"': '' }}>REJECTED</option>
                            </select>
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
                    <input type="submit" class="btn btn-primary submit pull-right" value="Update leave details" data-svalue="Updating leave details..." />
                </div>
            </div>
        </form>
        </div>

    </section>
@endsection