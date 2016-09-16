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
    


    {!! Form::open( array('url'=>'admin/employee/'.$emp->id.'/update/account_details', 'id'=>'form-update-employee-account-details', 'method'=>'post') ) !!}
    <section class="content clearfix">

    	@include('includes.dashboard.manage-employee-menu')
    	
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Acount Details</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>Email:</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="email" value="{{ $emp->email }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Account Type:</label><span class="text-danger">*</span>
                            <select class="form-control" name="account_type">
                                <option value="normal" {{ $emp->account_type == 'normal' ? 'selected="selected"': '' }}>Employee</option>
                                <option value="admin" {{ $emp->account_type == 'admin' ? 'selected="selected"': '' }}>Admin</option>
                                <option value="hr" {{ $emp->account_type == 'hr' ? 'selected="selected"': '' }}>Hr</option>
                                <option value="owner" {{ $emp->account_type == 'owner' ? 'selected="selected"': '' }}>Owner</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>ID No.:</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="identification" value="{{ $emp->identification }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Status: </label><span class="text-danger">*</span>
                            <select class="form-control" name="status">
                                <option  value="ACTIVE" {{ $emp->status == 'ACTIVE' ? 'selected="selected"': '' }}>ACTIVE</option>
                                <option  value="SUSPENDED" {{ $emp->status == 'SUSPENDED' ? 'selected="selected"': '' }}>SUSPENDED</option>
                                <option  value="UNCONFIRMED" {{ $emp->status == 'UNCONFIRMED' ? 'selected="selected"': '' }}>UNCONFIRMED</option>
                                <option  value="DELETED" {{ $emp->status == 'DELETED' ? 'selected="selected"': '' }}>DELETED</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Password:</label><span class="text-danger">*</span>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Confirm Password:</label><span class="text-danger">*</span>
                            <input type="password" class="form-control" name="confirm_password">
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
                
                <div class="action">
                    <input type="submit" class="btn btn-primary submit pull-right" value="Update Account Details" data-svalue="Updating account details..." />
                </div>
            </div>
        </div>

    </section>
    </form>
@endsection