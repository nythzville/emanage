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
        <li><a href="{{ BASE_URL }}/events"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Add Event</li>
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
            <div class="col-md-6">
                {!! Form::open( array('id'=>'form-edit-event', 'method'=>'post') ) !!}
                    <!-- text input -->
                    <div class="form-group">
                        <label>Event Name:</label>
                        <input type="event" class="form-control" name="event_name" value="{{ $event->event_name }}">
                    </div>

                    <div class="form-group">
                        <label>Event Details:</label>
                        <textarea type="event" class="form-control" name="event_details">{{ $event->event_details }}</textarea>
                    </div>

                    <div class='col-sm-6'>
                        <div class="form-group">
                            <div class='input-group date' id='datetimepicker2'>
                                <input type='text' class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $(function () {
                            $('#datetimepicker2').datetimepicker({
                                locale: 'en'
                            });
                        });
                    </script>

                    <div class="form-group">
                        <label>Event Location:</label>
                        <input type="event" class="form-control" name="event_location" value="{{ $event->event_location }}">
                    </div>

                    <div class="form-group">
                        <label>Event Address 1:</label>
                        <textarea type="event" class="form-control" name="event_address1">{{ $event->event_address1 }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Event Address 2:</label>
                        <textarea type="event" class="form-control" name="event_address2">{{ $event->event_address2 }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Event City:</label>
                        <input type="event" class="form-control" name="event_city" value="{{ $event->event_city }}">
                    </div>

                    <div class="form-group">
                        <label>Event Timezone:</label>
                        <input type="event" class="form-control" name="event_timezone" value="{{ $event->event_timezone }}">
                    </div>

                    <div class="form-group">
                        <label>Event State:</label>
                        <input type="event" class="form-control" name="event_state" value="{{ $event->event_state }}">
                    </div>

                    <div class="form-group">
                        <label>Event Province:</label>
                        <input type="event" class="form-control" name="event_province" value="{{ $event->event_province }}">
                    </div>

                    <div class="form-group">
                        <label>Event Postal:</label>
                        <input type="event" class="form-control" name="event_postal" value="{{ $event->event_postal }}">
                    </div>

                    <div class="form-group">
                        <label>Event Country:</label>
                        <input type="event" class="form-control" name="event_country" value="{{ $event->event_country }}">
                    </div>

                    <div class="form-group">
                        <label>Event Shortname:</label>
                        <input type="event" class="form-control" name="event_shortname" value="{{ $event->event_shortname }}">
                    </div>

                    <div class="form-group">
                        <label>Event URL:</label>
                        <input type="event" class="form-control" name="event_url" value="{{ $event->event_url }}">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Update Event">
                    </div>

                </div>

                {!! Form::close() !!}

        </div>

    </section>
@endsection