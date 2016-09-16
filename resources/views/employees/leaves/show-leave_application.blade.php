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
            <li class="active">Leave list</li>
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
            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Leaves List</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>No. of Days</th>
                          <th>Start Date</th>
                          <th>End Date</th>
                          <th>Note</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                            @foreach ( $leaves as $leave)
                            <tr>
                              <td><a href="{{ BASE_URL }}/employee/personal_information"> {{ ucwords($leave->employee->firstname.' '.$leave->employee->lastname ) }} </a></td>
                              <td>{{ $leave->no_of_days }}</td>
                              <td><span class="label label-primary">{{ $leave->start_date }}</span></td>
                              <td><span class="label label-primary">{{  $leave->end_date }}</span></td>
                              <td>{{  substr($leave->reason_of_leave, 0, 40). ''." ..." }}</td>
                              <td>
                                @if( $leave->leave_status == 'PENDING')
                                  <span class="label label-warning">{{  $leave->leave_status }}</span>
                                @endif

                                @if( $leave->leave_status == 'APPROVED')
                                  <span class="label label-success">{{  $leave->leave_status }}</span>
                                @endif
                                @if( $leave->leave_status == 'REJECTED')
                                  <span class="label label-danger">{{  $leave->leave_status }}</span>
                                @endif
                              </td>
                            </tr>
                            @endforeach
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
             </div>
        </div><!-- /.col-md-8 -->

       

    </section>
@endsection