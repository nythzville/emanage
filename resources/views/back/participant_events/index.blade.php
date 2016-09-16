@extends('layouts.users.default')

@section('content')
	<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo ucfirst(Auth::user()->user_firstname) ?> |
            <small>Add Event</small>
        </h1>

    </section>
    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">My Events</li>
    </ol>


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

            <a href="/export/joined_events" class="btn btn-primary submit">Export CSV - Joined Events</a>

            <br/><br/>

        <div class="box">
                <div class="box-header">
                  <h3 class="box-title"></h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-condensed">
                    <tbody>
                        <tr class="tbl-head">
                          <th style="width:20%">Event Date</th>
                          <th>Event Name</th>
                          <th style="width:40%" colspan="2">Actions</th>
                        </tr>
                    </tbody>
                        <?php $cnt = 1 ?>
                        @foreach( $participatedevents as $participatedevent )
                            <tr class="{{ $cnt++ % 2 == 0 ? 'even':'' }}" >
                                <td>{{ $participatedevent->event->event_date }}</td>
                                <td>{{ $participatedevent->event->event_name }}</td>
                                <td style="width: 350px">
                                    <a href="{{ BASE_URL }}/participant/detail/{{ $participatedevent->event->id }}">
                                        <button type="button" class="btn btn-success">Event Details</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                   </table>
                </div><!-- /.box-body -->
              </div>

        </div>

    </section>
@endsection