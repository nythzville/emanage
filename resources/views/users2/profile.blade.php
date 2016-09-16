@extends('layouts.users.default')

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
            <?php echo ucfirst($user->user_name) ?> | 
            <small>Details</small>
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
                        <td>{{ isset($user_data->user_address) ? $user_data->user_address : '' }}</td>
                    </tr>
                    <tr>
                        <th>Phone Number:</th>
                        <td>{{ isset($user_data->user_contact_details) ? $user_data->user_contact_details : '' }}</td>
                    </tr>
                </tbody>
            </table>
            <a href="{{ BASE_URL }}/edit/profile/" class="btn btn-primary edit_profile">Edit Profile</a>
          </div>
    </section>
@endsection