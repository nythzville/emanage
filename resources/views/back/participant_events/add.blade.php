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
                <tr>
                    <td><b>Event Name</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_name" class="form-control"></td>
                </tr>
                <tr>
                    <td>Event Date</td>
                </tr>
                <tr>
                    <td>
                <div class="input-group date form_datetime col-md-5" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                </div>
                    </td>
                </tr>
                <tr>
                    <td><b>Event Location</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_location" class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Event Address 1</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_address1"  class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Event Address 2</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_address2" class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Event City</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_city" class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Event Timezone</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_timezone" class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Event State</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_state" class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Event Province</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_province" class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Event Postal</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_postal" class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Event Country</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_country" class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Event Shortname</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_shortname" class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Event URL</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_url" class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Event Details</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_details" class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Event Location</b></td>
                </tr>
                <tr>
                    <td><input type="text" name="event_location" class="form-control"></td>
                </tr>
                <tr>
                    <td><b>Featured Event?</b></td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="event_featured" value="1"></td>
                </tr>
                <tr>
                    <td><br/><input type="submit" class="btn btn-primary" value="Add Event!"></td>
                </tr>
            </table>

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