@extends('layouts.dashboard')

@section('content')
	<!-- Content Header (Page header) -->

    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Event Participants</li>
    </ol>

    <section class="content">
        <div class="col-sm-12">
            {!! Form::open( array('id'=>'form-add-domain', 'method'=>'post') ) !!}
                <!-- text input -->

            <div class="info-msg" style="display: none">
                <div class="alert alert-danger">
                    <strong>Error!</strong> <span class="msg"></span>
                </div>
                <div class="alert alert-success">
                    <strong>Success!</strong> <span class="msg"></span>
                </div>
            </div>

            <a href="/event" class="btn btn-primary submit"><i class="fa fa-long-arrow-left"></i> Back to List</a>
            <a href="/export/event/{{ $event->id }}/event_participants" class="btn btn-primary submit">Export CSV - List of Participants</a>

            <br/><br/>

        <div class="box">
                
                <div class="box-body no-padding">

                <table class="table table-bordered domains-list">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Address 2</th>
                            <th>Action</th>
                        </tr>
                    @foreach($participatedevents as $participatedevent)
                        <tr>
                            <td>{{$participatedevent->participant_firstname}}</td>
                            <td>{{$participatedevent->participant_lastname}}</td>
                            <td>{{$participatedevent->participant_email}}</td>
                            <td>{{$participatedevent->participant_phone}}</td>
                            <td>{{$participatedevent->participant_address}}</td>
                            <td>{{$participatedevent->participant_address2}}</td>
                            <td>
                                <a href="{{ BASE_URL }}/event/{{$participatedevent->event_id}}/participants/{{$participatedevent->user_id}}" class="btn btn-default" title="Edit Participant">
                                   <i class="fa fa-pencil-square-o"></i> Edit
                                </a>
                                <a href="{{ BASE_URL }}/event/{{$participatedevent->event_id}}/participants/{{$participatedevent->user_id}}" class="btn btn-danger" title="Remove Participant">
                                   <i class="fa fa-trash"></i> Remove
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                </div><!-- /.box-body -->
              </div>

        </div>

        <div class="col-sm-12" style="margin-top: 50px;">
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

        </div>
    </section>
@endsection