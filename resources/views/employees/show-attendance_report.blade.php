<!-- Added by John Eiman Mission
	June 27, 2016
 -->
@extends('layouts.dashboard')
@section('content')
<?php $total_time_rendered = 0;
$total_lates = 0;
$logout_time = 0;?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <small>{{ ucwords($emp->firstname.' '.$emp->lastname) }} </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/employee/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
            <li>{{ ucwords($emp->firstname.' '.$emp->lastname) }} </li>
            <li class="active">Attendance Summary</li>
        </ol>
    </section>
    <section class="content clearfix">
    <div>
    	@include('includes.dashboard.employee.manage-employee-menu')
    </div>
    <?php
    if( isset($_GET['start_date']) && $_GET['start_date'] && isset($_GET['end_date']) && $_GET['end_date'] ) {
    	$from = date( $_GET['start_date']);
    	$to = date( $_GET['end_date']);
    }
    else {
    	$from = date('Y-m-d', strtotime(substr($weekly_attendance[0]->login_time,0,10)));
    	$to = date('Y-m-d');
    }
    	?>
    	<div class="col-md-9">
    		<div class="col-md-12">
	    		<form action=" " method="get" >
	    			<div class="box box-primary">
	    				<div class="box-header ui-sortable-handle " style="cursor: move;">
	    					<div class="box-body col-md-12">
	    						<div class="form-group  col-sm-5">
	    							<label class="col-sm-5">Start Date:<span class="text-danger">*</span></label>
	    							<input type="date" class=" col-sm-4 form-control" name="start_date" value={{$from}} >
	    						</div>
		    					<div class="form-group  col-md-5">
		    						<label class="col-sm-5">End Date:<span class="text-danger">*</span></label>
		    						<input type="date" class=" col-sm-4 form-control" name="end_date" value={{$to}} >
		    					</div>
		    					<div class="form-group  col-md-2">
		    						<label class="col-sm-2">&nbsp<span class="text-danger"></span></label>
		    						<input type="submit" class=" btn btn-primary submit col-sm-2 form-control"  value="Search"  >
		    					</div>
		    				</div>
	    				</div>
	    			</div>
	    		</form>
	    		@if(Session::has('flash_notice'))
			        <div class="info-msg">
			            <div class="alert alert-success">
			                <strong>Success!</strong> <span class="msg">{{ Session::get('flash_notice') }}</span>
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
	    	</div>  
    		<div class="col-md-12" id="test">
    			<div class="box box-primary">
    				<div class="to-be-printed" style="display:none;">
    					<div style="text-align: center">
    						{!! HTML::image('dashboard/images/mavericks-logo.png', 'Employee Management', array('class' => 'icon')) !!}<br/>
    						<span><strong>Mavericks Web Marketing and Solutions</strong><br/>
    							Dojo 8 Coworking Space, CPN Building<br/>
								General Luna Street, 5000 Iloilo City<br/>
								Iloilo, Philippines<br/>
							</span>
						</div><br/><br/>
						<span>Employee Name:&nbsp;&nbsp;&nbsp;</span><span style="text-transform:uppercase; text-decoration:underline" id="employee-name"></span><br/>
						<span>Job Title:&nbsp;&nbsp;&nbsp;</span><span style="text-transform:uppercase; text-decoration:underline">{{$employee->job_title}}</span><br/><br/>
						<span>REFERENCE DATES: {{date("F j, Y", strtotime($from))}} to {{date("F j, Y", strtotime($to))}}</span>
					</div>
					<div class="box-header with-border">
						<h3 class="box-title">Attendance Summary</h3>
					</div>
					<div class="box-body">
						<div id="table-responsive" class="table-responsive" style="height:300px;">
							<table class="table table-bordered table-hover">
								<thead>
									<th class="active"><label>DATE</label></th>
									<th class="active"><label>TIME IN</label></th>
									<th class="active"><label>TIME OUT</label></th>
									<th class="active"><label>TIME RENDERED</label></th>
									<th class="active"><label>REMARKS</label></th>
								</thead>
								<tbody>
									@foreach($weekly_attendance as $attendance)
									<tr>
										<td>
											<span class="label label-success">{{ date("F j, Y", strtotime(substr($attendance->login_time,0,10))) }}</span>
										</td>
										<td>
											<span class="label label-success">{{ date("g:i:s A", strtotime(substr($attendance->login_time,11,14))) }}</span>
										</td>
										<td>
											<span class="label label-success">
												@if(substr($attendance->logout_time,11,14) == '00:00:00')
												@if ( (string)(date("Y-m-d", strtotime(substr($attendance->login_time,0,10)))) != (string)(date("Y-m-d", time())) )
												<?php $logout_time = (string)(date("Y-m-d", strtotime(substr($attendance->login_time,0,10)))).' 17:00:00'; ?>
												{{ date("g:i:s A", strtotime($logout_time)) }}
												@else
												n/a
												@endif
												@else
												<?php $logout_time = $attendance->logout_time; ?>
												{{ date("g:i:s A", strtotime(substr($attendance->logout_time,11,14))) }}
												@endif

											</span>
										</td>
										<td>
											<span class="label label-success">
												<?php $total_lates += $attendance->lates; ?>
												@if( !($attendance->absent) && strtotime($logout_time)-strtotime($attendance->login_time) > 0 )
													
													@if ( (string)(date("Y-m-d", strtotime(substr($attendance->login_time,0,10)))) != (string)(date("Y-m-d", time())) )
														<?php $total_time_rendered += strtotime($logout_time)-strtotime($attendance->login_time)-(strtotime($attendance->stopbreak_time)-strtotime($attendance->break_time)); ?>
														{{ seconds_to_words( strtotime($logout_time)-strtotime($attendance->login_time)-(strtotime($attendance->stopbreak_time)-strtotime($attendance->break_time)))  }}
													@else
														<?php $total_time_rendered += strtotime($logout_time)-strtotime($attendance->login_time)-(strtotime($attendance->stopbreak_time)-strtotime($attendance->break_time)); ?>
														{{ seconds_to_words( strtotime($logout_time)-strtotime($attendance->login_time)-(strtotime($attendance->stopbreak_time)-strtotime($attendance->break_time)))  }}
													@endif
												@else
													n/a
												@endif
											</span>
										</td>
										<td>
											@if($attendance->status == 'LATE' || $attendance->status == 'LATE|OVERTIME')
											<span class="label label-warning">
											@elseif($attendance->status == 'ABSENT' || $attendance->status == 'LATE|UNDERTIME')
											<span class="label label-danger">
											@elseif($attendance->status == 'ONTIME')
											<span class="label label-primary">
											@elseif($attendance->status == 'EARLY' || $attendance->status == 'EARLY|OVERTIME')
											<span class="label label-success">
											@endif
											{{ $attendance->status }}</span>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<span class="label label-primary">TOTAL TIME RENDERED: {{ seconds_to_words($total_time_rendered) }}</span><span class="label label-warning" style="float: right; margin-top: 3px;">TOTAL LATES: {{ seconds_to_words($total_lates) }}</span>
						<div class="to-be-printed" style="display:none;">
							<div>
								<br/><br/><br/>Verified by:<br/><br/>
								______________________<br/>
								<strong>RAYJAND GELLAMUCHO</strong><br/>
								General Manager<br/><br/>
								Date: {{ date("F j, Y", time()) }}
							</div><br/>
		    			</div>
					</div>
				</div>
				<button class="btn btn-default" id="printbtn">Print Attendance Report Summary</button>
			</div>
		</div>
    </section>
@endsection