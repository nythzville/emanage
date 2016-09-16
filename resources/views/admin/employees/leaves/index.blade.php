@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        
        <h1>Leaves |
        
            <small> All</small>

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="active">Leave Management</li>
            <li class="active">{{ $is_all ? 'View all' : ''.$emp->firstname.' '.$emp->lastname }}</li>
        </ol>
    </section>
    
    <section class="content clearfix">

    	
      {!! Form::open( array('url'=>'admin/leaves' , 'method'=>'get') ) !!}
       <form action="/admin/leaves" method="get" >
        <div class="col-md-12">
            <div class="box box-primary">

                <div class="box-header with-border">
                  <div class="col-md-9 col-sm-8 name-box">
                    <h3 class="box-title">Leaves List </h3>
                  </div>
                
                  <div class="col-md-3 col-sm-4 name-box">
                   
                    <select class="form-control" name="employee_id" onchange="this.form.submit();">
                        <option value="">{{ $is_all ? 'Select Name:' : ''.$emp->firstname.' '.$emp->lastname }}</option>
                      @foreach ($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->firstname.' '.$emp->lastname }}</option>
                      @endforeach
                    </select>

                  </div>                     
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
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if( $leaves )
                            @foreach ($leaves as $leave)
                                <tr>
                                  <td><a href="{{ BASE_URL }}/admin/employee/{{ $leave->employee->id }}/personal_information"> {{ $leave->employee->firstname.' '.$leave->employee->lastname }} </a></td>
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
                                  <td>
                                      <a href="{{ BASE_URL }}/admin/leaves/{{ $leave->id }}/leave_details" title="View/Edit"> <i class="fa fa fa-share"></i> </a>
                                  </td>
                                </tr>
                            @endforeach                       
                        @endif
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
             </div>
        </div><!-- /.col-md-8 -->
      </form>


    </section>
@endsection

