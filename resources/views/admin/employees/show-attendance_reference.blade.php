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
            <li class="active">Attendance Reference</li>
        </ol>
    </section>

    @include('includes.dashboard.flash-message')
    

    <section class="content clearfix">

    	@include('includes.dashboard.manage-employee-menu')
    	<div class="col-md-9">
        @foreach( $week_days as $day_key => $day )
        {!! Form::open( array('url'=>'admin/employee/'.$emp->id.'/update/attendance_reference', 'id'=>'form-update-attendance-reference', 'method'=>'post') ) !!}
            <?php
                $time_in_H = '';
                $time_in_M = '';
                $time_in_S = '';

                $time_out_H = '';
                $time_out_M = '';
                $time_out_S = '';

                $disabled = 0;

                foreach ( $emp->attendance_reference as $attendance ) {
                    if( strtolower($day) == strtolower($attendance->day) ) {
                        $login_time_reference = explode(':', $attendance->login_time_reference);
                        $time_in_H = $login_time_reference[0];
                        $time_in_M = $login_time_reference[1];
                        $time_in_S = $login_time_reference[2];

                        $logout_time_reference = explode(':', $attendance->logout_time_reference);
                        $time_out_H = $logout_time_reference[0];
                        $time_out_M = $logout_time_reference[1];
                        $time_out_S = $logout_time_reference[2];

                        $disabled = $attendance->disabled;
                        break;
                    }
                }
            ?>
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $day }}[ 23:59:59 Format]</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-group  col-md-12">
                                                <label>TIME IN:</label>
                                            </div>

                                            <div class="form-group  col-md-4">
                                                <label class="font-normal">Hours:</label>
                                                <input type="text" value="{{ $time_in_H }}" class="form-control" name="hours_in">
                                            </div>

                                            <div class="form-group  col-md-4">
                                                <label class="font-normal">Minutes:</label>
                                                <input type="text" value="{{ $time_in_M }}" class="form-control" name="minutes_in">
                                            </div>

                                            <div class="form-group  col-md-4">
                                                <label class="font-normal">Seconds:</label>
                                                <input type="text" value="{{ $time_in_S }}" class="form-control" name="seconds_in">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="form-group  col-md-12">
                                                <label>TIME OUT:</label>
                                            </div>

                                            <div class="form-group  col-md-4">
                                                <label class="font-normal">Hours:</label>
                                                <input type="text"  value="{{ $time_out_H }}" class="form-control" name="hours_out">
                                            </div>

                                            <div class="form-group  col-md-4">
                                                <label class="font-normal">Minutes:</label>
                                                <input type="text"  value="{{ $time_out_M }}" class="form-control" name="minutes_out">
                                            </div>

                                            <div class="form-group  col-md-4">
                                                <label class="font-normal">Seconds:</label>
                                                <input type="text"  value="{{ $time_out_S }}" class="form-control" name="seconds_out">
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

                                    <div class="col-md-6">
                                        <input type="checkbox" name="disabled" value="1" {{ $disabled ? 'checked="checked"':'' }} /> <span class="bold">Disabled</span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="actions" style="text-align:right; padding-right: 20px">
                                            <input type="hidden" name="day_of" value="{{ strtolower($day) }}" />
                                            <input type="submit" class="btn btn-primary submit " value="Save" data-svalue="Saving..." />
                                        </div>
                                    </div>
                                    
                        </div>

                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        @endforeach


        </div>

    </section>
@endsection