@extends('layouts.dashboard')

@section('content')
    @if( isset($flash_notice) )
    <div class="info-msg">
        <div class="alert alert-info">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Success!</strong> <span class="msg">{{ $flash_notice }}</span>
        </div>
    </div>
    @endif

	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ ucfirst($employee->firstname) }} | 
            <small>My Profile</small>
        </h1>
    </section>

    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">My Profile</li>
    </ol>


    <section class="content">
        <div class="col-md-6">
        	<table class="table table-user-information">
                <tbody>
                    <tr>
                        <th>Address:</th>
                        <td>{{ isset($employees->address) ? $employees->address : '' }}</td>
                    </tr>
                    <tr>
                        <th>Phone Number:</th>
                        <td>{{ isset($employees->contact_details) ? $employees->contact_details : '' }}</td>
                    </tr>
                </tbody>
            </table>
            <a href="{{ BASE_URL }}/edit/profile/" class="btn btn-primary edit_profile">Edit Profile</a>
          </div>
    </section>
@endsection