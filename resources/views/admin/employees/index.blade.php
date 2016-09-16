@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Employees | 
            <small>View all</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Employees</a></li>
            <li class="active">View all</li>
        </ol>
    </section>

    @if(Session::has('flash_notice'))
        <div class="info-msg">
            <div class="alert alert-success">
                <strong>Succes!</strong> <span class="msg">{{ Session::get('flash_notice') }}</span>
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
        <?php  Session::forget('flash_notice'); ?>
    @endif


    {!! Form::open( array('url'=>'admin/employee/', 'id'=>'form-create-employee', 'method'=>'post') ) !!}
    <section class="content clearfix">
       
        <div class="col-md-9">
        	<div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Employees</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Employee ID</th>
                          <th>Name</th>
                          <th>Posittion</th>
                          <th>Status</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      	@if( $employees )
    			        	      @foreach ($employees as $emp)
    			        	          <tr>
    	                          <td><a href="/admin/employee/{{ $emp->id }}/account_details">{{ $emp->identification  }}</a></td>
    	                          <td><a href="/admin/employee/{{ $emp->id }}/personal_information">{{ $emp->firstname.' '.$emp->lastname }}</a></td>
    	                          <td>{{ $emp->job_title  }}</td>
    	                          <td><span class="label label-success">{{ 	$emp->employment_status }}</span></td>
                                
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
                  <h3 class="box-title">Latest Members</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    @if( !$latest_employees->isEmpty() )
                      @foreach ($latest_employees as $emp)
                      <li>
                        <?php if( $emp->photo ): ?>
                            <?php $emp_photo = str_replace('.jpg', '_50.jpg', $emp->photo) ?>
                            <?php $emp_photo = str_replace('.png', '_50.png', $emp_photo) ?>
                            <div style="height: 50px; overflow: hidden">
                              <img src="/images/employees/profile_photo/{{ $emp_photo }}?{{ rand(0, 500) }}" class="img-responsive center-block" />
                            </div>
                        <?php else: ?>
                            <div style="height: 50px; overflow: hidden">
                              <img src="/images/employees/profile_photo/{{ $emp->gender == 'male' ? 'male-default-photo-50.jpg' : 'female-default-photo-50.jpg' }}"  class="img-responsive center-block" />
                            </div>
                        <?php endif; ?>
                        <a class="users-list-name" href="/admin/employee/{{ $emp->id }}/personal_information">{{ $emp->firstname }}</a>
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