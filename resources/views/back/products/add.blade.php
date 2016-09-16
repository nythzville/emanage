@extends('layouts.dashboard')

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
            {!! Form::open(array('action' => 'EventsController@add', 'class' => 'form')) !!}
            <table class="col-sm-6">

            <div class="form-group">
                <label class="col-md-2 control-label">Event Name</label>
                <div class="col-md-4">
                    <input type="text" name="event_name" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Event Date</label>
                <div class="col-md-4">

                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="reservation">
                    </div>

                <br/>

                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Event Location</label>
                <div class="col-md-4">
                    <input type="text" name="event_location" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Event Address 1</label>
                <div class="col-md-4">
                    <input type="text" name="event_address1"  class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Event Address 2</label>
                <div class="col-md-4">
                    <input type="text" name="event_address2" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Event City</label>
                <div class="col-md-4">
                    <input type="text" name="event_city" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Event Timezone</label>
                <div class="col-md-4">
                    <input type="text" name="event_timezone" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Event State</label>
                <div class="col-md-4">
                    <input type="text" name="event_state" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Event Province</label>
                <div class="col-md-4">
                    <input type="text" name="event_province" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Event Postal</label>
                <div class="col-md-4">
                    <input type="text" name="event_postal" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-2 control-label">Event Country</label>
                <div class="col-md-4">
                    <input type="text" name="event_country" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Event Shortname</label>
                <div class="col-md-4">
                    <input type="text" name="event_shortname" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Event URL</label>
                <div class="col-md-4">
                    <input type="text" name="event_url" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Event Details</label>
                <div class="col-md-4">
                    <input type="text" name="event_details" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Event Location</label>
                <div class="col-md-4">
                    <input type="text" name="event_location" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-2 control-label">Featured Event?</label>
                <div class="col-md-4">
                    <input type="checkbox" name="event_featured" value="1">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-4">
                    <br/>
                    <input type="submit" class="btn btn-primary" value="Add Event!">
                </div>
            </div>


            {!! Form::close() !!}

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