@extends('layouts.admin-template')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Employee</h3>
            </div>
            <div class="title_right">
                
            </div>
        </div>
        <div class="clearfix"></div>
        
        <script type="text/javascript">
            $(document).ready(function () {
                $('#birthday').daterangepicker({
                    singleDatePicker: true,
                    calender_style: "picker_4"
                }, function (start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                });

                $('#start_date').daterangepicker({
                    singleDatePicker: true,
                    calender_style: "picker_4"
                }, function (start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                });
            });
        </script>
        <div class="row">
            <div id="alert-container" >
                
            </div>
        </div>

        <div class="row">           
            <div class="col-md-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Account<small>Details</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        {!! Form::open( array('url' => '/admin/employee/'.$employee->id, 'class'=>'employee-update-form form-horizontal form-label-left input_mask', 'id'=>'employee-employment-information-form', 'method'=>'put') ) !!}
                        <input type="hidden" name="what" value="account_details">

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <input type="text" name="identification" class="form-control has-feedback-left" placeholder="" required="" value="{{ $employee->identification }}">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                                <input type="text" name="email" class="form-control has-feedback-left" placeholder="Email" required="" value="{{ $employee->email }}">
                                <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Acount Type: </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select name="account_type" class="form-control" required="">
                                        <option value="normal" {{ $employee->user->user_type == 'normal' ? 'selected': '' }}>Normal</option>
                                        <option value="Admin" {{ $employee->user->user_type == 'Admin' ? 'selected': '' }}>Admin</option>
                                        <option value="hr" {{ $employee->user->user_type == 'hr' ? 'selected': '' }}>Hr</option>
                                        <option value="owner" {{ $employee->user->user_type == 'owner' ? 'selected': '' }}>Owner</option>
                            
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Status:</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select name="status" class="form-control" required="">
                                        <option value="ACTIVE" {{ $employee->status == 'ACTIVE' ? 'selected': '' }}>ACTIVE</option>
                                        <option value="SUSPENDED" {{ $employee->status == 'SUSPENDED' ? 'selected': '' }}>SUSPENDED</option>
                                        <option value="UNCONFIRMED" {{ $employee->status == 'UNCONFIRMED' ? 'selected': '' }}>UNCONFIRMED</option>
                                        <option value="DELETED" {{ $employee->status == 'DELETED' ? 'selected': '' }}>DELETED</option>
                            
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="password" name="password" class="form-control" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Re-type Password</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="password" name="confirm_password" class="form-control" required="">
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Personal<small>information</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            {!! Form::open( array('url' => '/admin/employee/'.$employee->id, 'class'=>'employee-update-form form-horizontal form-label-left input_mask', 'id'=>'employee-employment-information-form', 'method'=>'put') ) !!}
                            <input type="hidden" name="what" value="personal_information">

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" name="firstname" class="form-control has-feedback-left" placeholder="First Name" required="" value="{{ $employee->firstname }}">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" name="lastname" class="form-control" placeholder="Last Name" required="" value="{{ $employee->lastname }}">
                                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" name="middlename" class="form-control has-feedback-left" placeholder="Middle Name" required="" value="{{ $employee->middlename }}">
                                <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" id="birthday" name="birthdate" class="form-control" placeholder="Birth Date" required="" value='{{ Date("m/d/y", strtotime($employee->birthdate)) }}'>
                                <span class="fa fa-user form-control-feedback right" aria-hidden="true"></span>
                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" name="phone_no" class="form-control \ has-feedback-left" placeholder="Phone" required="" value="{{ $employee->phone_no }}">
                                <span class="fa fa-phone form-control-feedback left" aria-hidden="true"></span>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                                <input type="text" name="mobile_no" class="form-control" placeholder="Mobile" required="" value="{{ $employee->mobile_no }}">
                                <span class="fa fa-mobile form-control-feedback right" aria-hidden="true"></span>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="gender" class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default {{ $employee->gender == 'male' ? 'active' : '' }}" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="male"> &nbsp; Male &nbsp;
                                        </label>
                                        <label class="btn btn-primary {{ $employee->gender == 'female' ? 'active' : '' }}" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="female"> Female
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Address</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" name="address" class="form-control" placeholder="address" required="" value="{{ $employee->address }}">
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>

                </div>

                <div class="col-md-6 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Employment<small>information</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            {!! Form::open( array('url' => '/admin/employee/'.$employee->id, 'class'=>'employee-update-form form-horizontal form-label-left input_mask', 'id'=>'employee-employment-information-form', 'method'=>'put') ) !!}
                            <input type="hidden" name="what" value="work_details">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Start Date:</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input name="start_date" id="start_date" type="text" class="form-control" placeholder="mm/dd/yyyy" required="" value='{{ Date("m/d/y", strtotime($employee->start_date )) }}'>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Department</label>
                               
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select name="department_id" class="form-control" required="">
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ ($employee->department_id == $department->id)? 'selected': '' }}>{{ $department->name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Job Title</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input name="job_title" type="text" class="form-control" placeholder="Job Title" required="" value=" {{ $employee->job_title }}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Job Description
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea name="job_description" class="form-control" rows="3" placeholder='Job Description' required="">{{ $employee->job_description }}</textarea>
                                </div>

                                <script type="text/javascript"></script>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label">Employment
                                    <br>
                                    <small class="text-navy">Status</small>
                                </label>

                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="flat" value="employed" checked name="employment_status" required="" {{ $employee->employment_status == 'employed' ? 'checked' : '' }}> Employed
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="flat" value="resigned" name="employment_status" required="" {{ $employee->employment_status == 'resigned' ? 'checked' : '' }}> Resigned
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="flat" value="AWOL" name="employment_status" required="" {{ $employee->employment_status == 'AWOL' ? 'checked' : '' }}
                                            > AWOL
                                        </label>
                                    </div>
                                </div>
                            
                                <label class="col-md-2 col-sm-2 col-xs-12 control-label">
                                    <br>
                                    <small class="text-navy">Type</small>
                                </label>

                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="flat" value="fulltime" name="employment_type" {{ $employee->employment_type == 'fulltime' ? 'checked' : '' }}> Full Time
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="flat" value="parttime" name="employment_type" {{ $employee->employment_type == 'parttime' ? 'checked' : '' }}> Part Time
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>

                            {!! Form::close() !!}

                        </div>
                    </div>

                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Attendance<small>Reference</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            {!! Form::open( array('url' => '/admin/employee/'.$employee->id, 'class'=>'employee-update-form form-horizontal form-label-left input_mask', 'id'=>'employee-attendance-reference', 'method'=>'put') ) !!}
                            <input type="hidden" name="what" value="attendance_reference">

                             <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Option</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="gender" class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-default {{ $employee->gender == 'male' ? 'active' : '' }}" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="male"> &nbsp; Male &nbsp;
                                        </label>
                                        <label class="btn btn-primary {{ $employee->gender == 'female' ? 'active' : '' }}" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="gender" value="female"> Female
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="flat" value="default" name="attendance_reference_option"> Default
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="flat" value="custom" name="attendance_reference_option" checked=""> Custom
                                        </label>
                                    </div>
                                </div>
                                
                            </div>

                            <br/>
                            <div class="form-group">
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <label>Day</label>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <label>Login Time</label>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <label>Logout Time</label>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <label>Enable</label>
                                </div>
                            </div>

                            @foreach($employee->attendanceReference as $attendance)
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3">{{ $attendance->day }}</label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input name="{{$attendance->day}}_login_time_reference" type="text" class="form-control {{$attendance->day}}" placeholder="00:00:00" required="" value="{{ $attendance->login_time_reference }}" data-inputmask="'mask': '99:99:99'" {{ $attendance->disabled ? 'disabled': ''}}>
                                </div>  
                                <div class="col-md-3 col-sm-3 col-xs-3">
                                    <input name="{{$attendance->day}}_logout_time_reference" type="text" class="form-control {{$attendance->day}}" placeholder="Job Title" required="" value=" {{ $attendance->logout_time_reference }}" data-inputmask="'mask': '99:99:99'" {{ $attendance->disabled ? 'disabled': ''}}>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-1">
                                    <input name="{{$attendance->day}}_enable" type="checkbox" class="flat {{$attendance->day}}" {{ $attendance->disabled? '' : 'checked' }}>
                                </div>
                            </div>

                            @endforeach

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                                    <button type="submit" class="btn btn-success">Save</button>
                                </div>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            
            </div>
        </div>

    </div>
    <!-- /page content -->

    <!-- input mask -->
    <script src="{{ url() }}/js/input_mask/jquery.inputmask.js"></script>
    <!-- input_mask -->
    <script>
        $(document).ready(function () {

            $("input[name='attendance_reference_option']:checked").(function(){
                console.log("heelo");
            });
            console.log($("input[name='attendance_reference_option']:checked").val());
               


            $(":input").inputmask();
        });
    </script>
    <!-- /input mask -->

@endsection