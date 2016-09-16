@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Leave | 
            <small>Create New </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="active">Leave Management </li>
            <li class="active">Create New </li>
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
	    

	        <div class="col-md-12">
	           
	            {!! Form::open( array('url'=>'admin/leaves/', 'id'=>'form-create-leave','method'=>'post') ) !!}
	            <div class="box box-primary">
	                <div class="box-header with-border">
	                    <h3 class="box-title">Leave/Absent Form</h3>
	                </div>
	                <div class="box-body">
	                    <div class="row">

	                        <div class="form-group  col-md-6">
							 	<label>Name:</label><span class="text-danger">*</span>
								<select class="form-control" name="firstname">
									@foreach ($employees as $emp)
										<option value="{{ $emp->id }}">{{ $emp->firstname.' '.$emp->lastname}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-6">
								<label>Number of days:</label>
	                            <input type="text" class="form-control" name="no_of_days" value="" placeholder="Total Number of Days" >
	                        </div>
	                         
	                    </div>

	                    <div class="row">
	                        <div class="form-group col-md-6">
	                            <label>Start Date Date:</label><span class="text-danger"> *</span>
	                            <input type="date" class="form-control" name="start_date" value=""  >
	                        </div>

	                        <div class="form-group col-md-6">
	                            <label>End Date:</label><span class="text-danger"> *</span>
	                            <input type="date" class="form-control" name="end_date" value="" >
	                        </div>
	                    </div>

	                    <div class="row">
	                        <div class="form-group col-md-12">
	                            <label>Reason of Absence/Leave:</label><span class="text-danger"> *</span>
	                            <textarea class="form-control" style="min-height: 80px" name="reasons" placeholder="Minimum of 50 characters"></textarea>
	                        </div>
	                    </div>

	                     <div class="row">
	                        <div class="form-group col-md-12">
	                            <label>Note:</label>
	                            <textarea class="form-control" style="min-height: 80px" name="note_for_absent"></textarea>
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
	                    <input type="submit" class="btn btn-primary submit pull-right" value="Submit" data-svalue="submitting leave form..." />
	                </div>
	            </div>
	        </form>
	        </div>

	    </section>
@endsection