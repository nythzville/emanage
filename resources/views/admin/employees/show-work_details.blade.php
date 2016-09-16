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
            <li>{{ ucwords($emp->firstname.' '.$emp->lastname) }} </li>
            <li class="active">Work Details</li>
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

    {!! Form::open( array('url'=>'admin/employee/'.$emp->id.'/update/work_details', 'id'=>'form-update-employee-work-details', 'method'=>'post') ) !!}
    <section class="content clearfix">

    	@include('includes.dashboard.manage-employee-menu')
    	
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Work Details</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Start Date:</label><span class="text-danger">*</span>  MM/DD/YYYY
                            <input type="text" class="form-control" name="start_date" value="{{ date('m/d/Y', strtotime($emp->start_date) ) }}" placeholder="MM/DD/YYYY" >
                        </div>

                        <div class="form-group  col-md-6">
                            <label>Status:</label><span class="text-danger">*</span>
                            <select class="form-control" name="employment_status">
                                <option value="employed" {{ $emp->employment_status == 'employed' ? 'selected="selected"': ''}} > Employed</option>
                                <option value="resigned" {{ $emp->employment_status == 'resigned' ? 'selected="selected"': ''}} >Resigned</option>
                                <option value="AWOL" {{ $emp->employment_status == 'AWOL' ? 'selected="selected"': ''}} >AWOL</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group  col-md-6">
                            <label>Job Title:</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="job_title" value="{{ $emp->job_title }}" placeholder="Programmer" >
                        </div>

                        <div class="form-group  col-md-6">
                            <label>Department:</label><span class="text-danger">*</span>
                            <select class="form-control" name="department_id">
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" {{ $emp->department_id == $department->id ? 'selected="selected"': '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                            <label>Employment Type:</label><span class="text-danger">*</span>
                            <select class="form-control" name="employment_type">
                                <option value="fulltime" {{ $emp->employment_type == 'fulltime' ? 'selected="selected"': '' }}>Full Time</option>
                                <option value="parttime" {{ $emp->employment_type == 'parttime' ? 'selected="selected"': '' }}>Part Time</option>
                                <option value="contractual" {{ $emp->employment_type == 'contractual' ? 'selected="selected"': '' }}>Contractual</option>
                                <option value="others" {{ $emp->employment_type == 'others' ? 'selected="selected"': '' }}>Others</option>
                            </select>
                    </div>

                    <div class="form-group">
                        <label>Job Description:</label><span class="text-danger">*</span>
                        <textarea class="form-control" style="min-height: 200px" name="job_description">{{ $emp->job_description }}</textarea>
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
                    <input type="submit" class="btn btn-primary submit pull-right" value="Update Work Details" data-svalue="Updating work details..." />
                </div>

            </div>
        </div>
        
        

    </section>
    </form>
@endsection