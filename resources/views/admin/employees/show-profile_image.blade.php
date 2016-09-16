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
            <li class="active">Account Details</li>
        </ol>
    </section>

    @include('includes.dashboard.flash-message')
    

    {!! Form::open( array('url'=>'admin/employee/'.$emp->id.'/update/profile_image', 'method'=>'post', 'files'=>true ) ) !!}
    <section class="content clearfix">

    	@include('includes.dashboard.manage-employee-menu')
    	
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Profile Image</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-lg-8">
                            <div>
                                <?php if( $emp->photo ): ?>
                                    <?php $emp_photo = str_replace('.jpg', '_200.jpg', $emp->photo) ?>
                                    <?php $emp_photo = str_replace('.png', '_200.png', $emp_photo) ?>
                                    <img src="/images/employees/profile_photo/{{ $emp_photo }}?{{ rand(0, 500) }}" class="img-responsive" />
                                <?php else: ?>
                                    <img src="/images/employees/profile_photo/{{ $emp->gender == 'male' ? 'male-default-photo-200.jpg' : 'female-default-photo-200.jpg' }}"  class="img-responsive" />
                                <?php endif; ?>
                            </div>
                            <br />
                            {!! Form::file('profile_photo') !!}
                        </div>
                        <div class="action" style="padding-top: 0px">
                            <input type="submit" class="btn btn-primary submit pull-right" value="Update Profile Image" data-svalue="Updating Profile Image..." />
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

    </section>
    </form>
@endsection