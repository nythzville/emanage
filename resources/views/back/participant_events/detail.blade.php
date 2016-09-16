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
        <li class="active">Add Event</li>
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

            <a href="/events" class="btn btn-primary submit">Back to List</a>

            <br/><br/>

        <div class="box">
                <div class="box-header">
                  <h3 class="box-title"></h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                  <table class="table table-bordered domains-list">

                    @foreach( $events as $event )
                        <tr>
                            <td>Event Date</td><td>{{ $event->event_date }}</td>
                        </tr>
                        <tr>
                            <td>Event Name</td><td>{{ $event->event_name}}</td>
                        </tr><tr>
                            <td>Event Description</td><td>{{ $event->event_description}}</td>
                        </tr><tr>
                            <td>Event Details</td><td>{{ $event->event_details}}</td>
                        </tr><tr>
                            <td>Event Timezone</td><td>{{ $event->event_timezone}}</td>
                        </tr><tr>
                            <td>Event Location</td><td>{{ $event->event_location}}</td>
                        </tr><tr>
                            <td>Event Address 1</td><td>{{ $event->event_address1}}</td>
                        </tr><tr>
                            <td>Event Address 2</td><td>{{ $event->event_address2}}</td>
                        </tr><tr>
                            <td>Event City</td><td>{{ $event->event_city}}</td>
                        </tr><tr>
                            <td>Event Url</td><td>{{ $event->event_url}}</td>
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