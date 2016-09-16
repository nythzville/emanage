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
            <li class="active">Account Details</li>
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
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Acount Details</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-lg-4">
                            <label>Email:</label>
                            <input disabled type="text" class="form-control" name="email" value="{{ $emp->email }}">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Account Type:</label>
                            <select class="form-control" name="account_type" disabled>
                                <option value="normal" {{ $emp->account_type == 'normal' ? 'selected="selected"': '' }}>Employee</option>
                                <option value="admin" {{ $emp->account_type == 'admin" {' ? 'selected="selected"': '' }}>Admin</option>
                                <option value="hr" {{ $emp->account_type == 'hr' ? 'selected="selected"': '' }}>Hr</option>
                                <option value="owner" {{ $emp->account_type == 'owner' ? 'selected="selected"': '' }}>Owner</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-4">
                            <label>ID No.:</label>
                            <input disabled type="text" class="form-control" value="{{ $emp->identification }}">
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
@endsection