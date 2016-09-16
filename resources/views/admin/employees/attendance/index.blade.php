@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Attendance Mangement | 
            <small>Today</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Attendance Mangement</a></li>
            <li class="active">View all</li>
        </ol>
    </section>

    @if(Session::has('flash_notice'))
        <div class="info-msg">
            <div class="alert alert-success">
                <strong>Success!</strong> <span class="msg">{{ Session::get('flash_notice') }}</span>
            </div>
        </div>
         <?php  Session::forget('flash_notice'); ?>
    @endif

    @if(Session::has('flash_error'))
        <div class="info-msg" >
            <div class="alert alert-danger">
                <strong>Error!</strong> <span class="msg">{{ Session::get('flash_error') }}</span>
            </div>
        </div>
         <?php  Session::forget('flash_error'); ?>
    @endif


<!--     {!! Form::open( array('url'=>'admin/employee/', 'id'=>'form-create-employee', 'method'=>'post') ) !!}
 -->    <section class="content clearfix">
        
          <div class="col-md-12">
            <form action=" " method="get" >
              <div class="box box-primary">
                  <div class="box-header ui-sortable-handle " style="cursor: move;">
                    <div class="box-body col-md-12">
                      <div class="form-group  col-sm-5">
                        <label class="col-sm-5">Start Date:<span class="text-danger">*</span></label>   
                        <input type="date" class=" col-sm-4 form-control" name="start_date" value="{{ $is_weekly ? '' : ''.$from }}"  >
                      </div>

                      <div class="form-group  col-md-5">
                        <label class="col-sm-5">End Date:<span class="text-danger">*</span></label>   
                        <input type="date" class=" col-sm-4 form-control" name="end_date" value="{{ $is_weekly ? '' : ''.$to }}"  >
                      </div>

                      <div class="form-group  col-md-2">
                        <label class="col-sm-2">&nbsp<span class="text-danger"></span></label>   
                        <input type="submit" class=" btn btn-primary submit col-sm-2 form-control"  value="Submit Date"  >
                      </div>
                    </div>

                  </div>
                </div>
              </form>
          </div>  
        
       
        <div class="col-md-9">
        	<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Logins</h3>
                  <h3 class="box-title pull-right">{{ $is_weekly ? ''.date('l, F d'): ''}} </h3>
                  <h3 class="box-title pull-right">{{ $is_weekly ? '' : 'To: '  .date('F d, Y',strtotime($to))}} </h3>
                  <h3 class="box-title pull-right">{{ $is_weekly ? '' : 'From: '.date('F d, Y',strtotime($from))}}</h3> 

                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Employee ID</th>
                          <th>Name</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      	@if( $attendance )
      			        	    @foreach ($attendance as $attnd)

      			        	    <tr>
      	                          <td><a href="{{ BASE_URL }}/admin/employee/{{ $attnd->employee->id }}/account_details">{{ $attnd->employee->identification  }}</td>
      	                          <td><a href="{{ BASE_URL }}/admin/employee/{{ $attnd->employee->id }}/personal_information">{{ $attnd->employee->firstname.' '.$attnd->employee->lastname }}</td>
      	                          <td>
                                    <!-- @foreach ( $statuses = explode('|', $attnd->status) as $status )
                                      <span class="label label-{{ 
                                        ( in_array( $status, array('LATE', 'ABSENT', 'UNDERTIME') ) ) ? 'danger' : 'success'
                                      }}">{{ $status }}</span>
                                    @endforeach -->
                                    @foreach ( $statuses = explode('|', $attnd->status) as $status )
                                      @if( $status == 'EARLY' )
                                        <small class="label label-success">EARLY</small>
                                      @endif
                                      @if( $status == 'LATE' )
                                        <small class="label label-warning">LATE</small>
                                      @endif
                                      @if( $status == 'ABSENT' )
                                        <small class="label label-danger">ABSENT</small>
                                      @endif
                                      @if( $status == 'UNDERTIME' )
                                        <small class="label label-warning">UNDERTIME</small>
                                      @endif
                                      @if( $status == 'OVERTIME' )
                                        <small class="label label-success">OVERTIME</small>
                                      @endif
                                    @endforeach
                                  </td>

                                  <td>
                                    <a href="{{ BASE_URL }}/admin/employee/attendance/{{ $attnd->employee->id }}/show_attendance" title="View Weekly Attendance">Weekly Attendance</a>
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


        <div class="col-md-3">
          <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">On Leave </h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    @if( !$on_leave->isEmpty() )
                      @foreach ($on_leave as $emp)
                      <li>
                        <?php if( $emp->employee->photo ): ?>
                            <?php $emp_photo = str_replace('.jpg', '_50.jpg', $emp->employee->photo) ?>
                            <?php $emp_photo = str_replace('.png', '_50.png', $emp_photo) ?>
                            <div style="height: 50px; overflow: hidden">
                              <img src="/images/employees/profile_photo/{{ $emp_photo }}?{{ rand(0, 500) }}" class="img-responsive center-block" />
                            </div>
                        <?php else: ?>
                            <div style="height: 50px; overflow: hidden">
                              <img src="/images/employees/profile_photo/{{ $emp->employee->gender == 'male' ? 'male-default-photo-50.jpg' : 'female-default-photo-50.jpg' }}"  class="img-responsive center-block" />
                            </div>
                        <?php endif; ?>
                        <a class="users-list-name" href="/admin/employee/{{ $emp->employee->id }}/personal_information">{{ $emp->employee->firstname }}</a>
                      </li>
                      @endforeach
                    @endif   
                  </ul><!-- /.users-list -->
                </div><!-- /.box-body -->
             </div>
        </div>


        <div class="clearfix clear"></div>

        <div class="info-msg" style="display: none">
			<div class="alert alert-danger">
			    <a href="#" class="close" data-dismiss="alert">&times;</a>
			    <strong>Error!</strong> <span class="msg"></span>
			</div>
			<div class="alert alert-success">
			    <a href="#" data-dismiss="alert">&times;</a>
			    <strong>Success!</strong> <span class="msg"></span>
			</div>
		</div>
		

    </section>
    </form>
@endsection