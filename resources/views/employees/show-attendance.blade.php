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
		<li class="active">Attendance</li>
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
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Time In / Time Out</h3>
				</div>
				<div class="box-body">
					<div class="row">
						<div class="col-md-6" id="loginclass">
							{!! Form::open( array('url'=>'employee/attendance/login','class'=>'form-attendance-login', 'method'=>'post') ) !!}
								<input type="submit" id="loginbtn" class="btn btn-primary submit login-logout-btn " value="Time In" data-svalue="Logging in..."
								@foreach( $weekly_attendance as $attendance )
									<?php $log_date = date("Y-m-d",strtotime($attendance->login_time));
									$cur_date = date("Y-m-d"); ?>
									@if($log_date == $cur_date)
										{{ 'disabled="disabled"' }}
									@endif
								@endforeach
								/>
							{!! Form::close() !!}
						</div>
						<div class="col-md-6" id="breakclass" style="display:none;">
							{!! Form::open( array('url'=>'employee/attendance/break','class'=>'form-attendance-break', 'method'=>'post') ) !!}
								<input type="submit" id="breakbtn" class="btn btn-warning submit login-logout-btn " value="Break" data-svalue="Taking a break..."
								@foreach( $weekly_attendance as $attendance )
									<?php $log_date = date("Y-m-d",strtotime($attendance->break_time));
									$cur_date = date("Y-m-d"); ?>
									@if($log_date == $cur_date)
										{{ 'disabled="disabled"' }}
									@endif
								@endforeach
								/>
							{!! Form::close() !!}
						</div>
						<div class="col-md-6" id="stopbreakclass" style="display:none;">
							{!! Form::open( array('url'=>'employee/attendance/stopbreak','class'=>'form-attendance-stopbreak', 'method'=>'post') ) !!}
								<input type="submit" id="stopbreakbtn" class="btn btn-warning submit login-logout-btn " value="End Break" data-svalue="Ending your break..."
								@foreach( $weekly_attendance as $attendance )
									<?php $log_date = date("Y-m-d",strtotime($attendance->stopbreak_time));
									$cur_date = date("Y-m-d"); ?>
									@if($log_date == $cur_date)
										{{ 'disabled="disabled"' }}
									@endif
								@endforeach
								/>
							{!! Form::close() !!}
						</div>
						<div class="col-md-6" id="logoutclass">
							{!! Form::open( array('url'=>'employee/attendance/logout','class'=>'form-attendance-logout', 'method'=>'post') ) !!}
								<input type="submit" id="logoutbtn" class="btn btn-danger submit login-logout-btn " value="Time Out" data-svalue="Logging out..."
								@foreach( $weekly_attendance as $attendance )
									<?php $logout = date("Y-m-d",strtotime($attendance->logout_time));
									$current = date("Y-m-d"); ?>
									@if($logout == $current)
										{{ 'disabled="disabled"' }}
									@endif
								@endforeach
								/>
							{!! Form::close() !!}
						</div>
						<div id="breaktimer">
							<div id="breaktimerreload">
								@foreach( $weekly_attendance as $attendance )
									<?php $log_date = date("Y-m-d",strtotime($attendance->break_time));
									$cur_date = date("Y-m-d"); ?>
									@if($log_date == $cur_date)
										<?php $break_time_elapsed =  time() - strtotime($attendance->break_time);
										$hours = floor($break_time_elapsed/ 3600);
										$mins = floor($break_time_elapsed/ 60 % 60);
										$secs = floor($break_time_elapsed% 60);
										?>
										@if($attendance->break==0)
										<span class="label label-warning" style="margin-left: 2%;background-color:#f39c12">ON BREAK: 
												@if($hours <= 0)
													{{ $mins." mins ".$secs." secs" }}
												@else
													{{ $hours." hours ".$mins." mins ".$secs." secs" }}
												@endif
											@endif
										</span>
									@endif
								@endforeach
							</div>
						</div>
						<div class="col-xs-12 attendance-record-result">
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
		</div>
		<span id="testonly"></span>
		<span id="testonly1"></span>
		<div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header ui-sortable-handle" style="cursor: move;">
					<i class="ion ion-clipboard"></i>
					<h3 class="box-title">Weekly Attendance Report</h3>
				</div><!-- /.box-header -->
				<div class="box-body" id="boxbodymain">
					<ul class="todo-list ui-sortable"  id="boxbody">
					<?php  $total_lates = 0;
					$total_undertime = 0; 
					$total_early = 0;
					$total_overtime = 0;
					$total_break = 0;
					?>

					@foreach( $weekly_attendance as $attendance )
						<li>
							<!-- drag handle -->
							<span class="handle ui-sortable-handle">
								<i class="fa fa-ellipsis-v"></i>
								<i class="fa fa-ellipsis-v"></i>
							</span>
							<!-- todo text -->
							<span class="text">{{ ucfirst($attendance->day) }}</span>
							<!-- Check if EARLY -->
							@if( $attendance->early )
								<?php $total_early += $attendance->early; ?>
								<small class="label label-success">EARLY: {{ seconds_to_words( $attendance->early ) }}</small>
							@endif
							<!-- Check if ABSENT -->
							@if( $attendance->absent )
								<small class="label label-danger">ABSENT</small>
							@endif
							<!-- Check if LATE -->
							@if( $attendance->lates )
								<?php $total_lates += $attendance->lates; ?>
								<small class="label label-warning">LATE: {{ seconds_to_words( $attendance->lates ) }}</small>
							@endif
							<!-- Check if UNDERTIME -->
							@if( $attendance->undertime )
								<?php $total_undertime += $attendance->undertime; ?>
								<small class="label label-warning">UNDERTIME: {{ seconds_to_words( $attendance->undertime ) }}</small>
							@endif
							@if( $attendance->overtime )
								<?php $total_overtime += $attendance->overtime; ?>
								<small class="label label-success">OVERTIME: {{ seconds_to_words( $attendance->overtime ) }}</small>
							@endif
							@if( strtotime($attendance->logout_time)-strtotime($attendance->login_time) > 0 )
								<small style="float:right" class="label label-primary">TOTAL TIME RENDERED<br/>{{ seconds_to_words( strtotime($attendance->logout_time)-strtotime($attendance->login_time)-(strtotime($attendance->stopbreak_time)-strtotime($attendance->break_time)))  }}</small>
							@endif
						</li>
						<?php $total_break += (strtotime($attendance->stopbreak_time)-strtotime($attendance->break_time)); ?>
					@endforeach
				</ul>
			</div><!-- /.box-body -->
			<div class="box-footer clearfix no-border" id="detailed-data">
				<div id="refresh-detailed-data">
					<div class="col-xs-3"><span class="bold">Total Early :</span> 
						<div id="total-early">{{ seconds_to_words( $total_early ) }}</div>
					</div>
					<div class="col-xs-3"><span class="bold">Total Lates :</span>
						<div id="total-lates">{{ seconds_to_words( $total_lates ) }}</div>
					</div>
					<div class="col-xs-3"><span class="bold">Total Undertime :</span> 
						<div id="total-undertime">{{ seconds_to_words( $total_undertime ) }}</div>
					</div>
					<div class="col-xs-3"><span class="bold">Total Overtime :</span> 
						<div id="total-overtime">{{ seconds_to_words( $total_overtime ) }}</div>
					</div>
					@if( $total_break > 0)
						<div class="col-xs-3"><span class="bold">Total Break :</span> 
							<div id="total-break">{{ seconds_to_words( $total_break ) }}</div>
						</div>
					@endif
				</div>
				<span id="timer"></span>
			</div>
		</div>
	</div>  
</div>
</section>
@endsection