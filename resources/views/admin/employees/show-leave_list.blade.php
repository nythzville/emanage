@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        
        <h1>Leaves |
        
            <small> {{ $emp->firstname.' '.$emp->lastname }}</small>

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="active">{{ $emp->firstname.' '.$emp->lastname }}</li>
            <li class="active">View Leaves</li>
        </ol>
    </section>

    @include('includes.dashboard.flash-message')
    
    
    <section class="content clearfix">

    @include('includes.dashboard.manage-employee-menu')
      {!! Form::open( array('url'=>'admin/leaves' , 'method'=>'get') ) !!}
       <form action="/admin/leaves" method="get" >
        <div class="col-md-9">
            <div class="box box-primary">

                <div class="box-header with-border">
                  <div class="col-md-12 col-sm-12 name-box">
                    <h3 class="box-title">Leaves List </h3>
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
                                  <td>{{  substr($leave->reason_of_leave, 0, 25). ''." ..." }}</td>
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

