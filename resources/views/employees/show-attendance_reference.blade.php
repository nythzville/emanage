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
            <li class="active">Attendance Reference</li>
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
        @foreach( $week_days as $day_key => $day )
        <?php
            $time_in_H = '';
            $time_in_M = '';
            $time_in_S = '';

            $time_out_H = '';
            $time_out_M = '';
            $time_out_S = '';

            $found = false;

            foreach ( $attendance_reference as $attendance ) {
                if( strtolower($day) == strtolower($attendance->day) ) {
                    $login_time_reference = explode(':', $attendance->login_time_reference);
                    $time_in_H = $login_time_reference[0];
                    $time_in_M = $login_time_reference[1];
                    $time_in_S = $login_time_reference[2];

                    $logout_time_reference = explode(':', $attendance->logout_time_reference);
                    $time_out_H = $logout_time_reference[0];
                    $time_out_M = $logout_time_reference[1];
                    $time_out_S = $logout_time_reference[2];
                    $found = true;
                    break;
                }
            }

            // If disabled, just skip
            if( !$found ) continue;
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
                                        <input type="text" disabled value="{{ $time_in_H }}" class="form-control" name="hours_in">
                                    </div>

                                    <div class="form-group  col-md-4">
                                        <label class="font-normal">Minutes:</label>
                                        <input type="text" disabled value="{{ $time_in_M }}" class="form-control" name="minutes_in">
                                    </div>

                                    <div class="form-group  col-md-4">
                                        <label class="font-normal">Seconds:</label>
                                        <input type="text" disabled value="{{ $time_in_S }}" class="form-control" name="seconds_in">
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
                                        <input type="text" disabled  value="{{ $time_out_H }}" class="form-control" name="hours_out">
                                    </div>

                                    <div class="form-group  col-md-4">
                                        <label class="font-normal">Minutes:</label>
                                        <input type="text" disabled  value="{{ $time_out_M }}" class="form-control" name="minutes_out">
                                    </div>

                                    <div class="form-group  col-md-4">
                                        <label class="font-normal">Seconds:</label>
                                        <input type="text" disabled  value="{{ $time_out_S }}" class="form-control" name="seconds_out">
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

                </div>
            </div>
        </div>
        @endforeach


        </div>

    </section>
@endsection