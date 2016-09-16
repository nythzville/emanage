@extends('layouts.dashboard')

@section('content')
	<!-- Content Header (Page header) -->

    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Event Details</li>
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
            <a href="#" class="btn btn-primary pull-right"><i class="fa fa-eye"></i> View Event Products</a>
           

            <br/><br/>

        <div class="box">
                
                <div class="box-body no-padding">
                  <table class="table table-bordered domains-list">
                   
                    @foreach( $events as $event )
                        <tr>
                            <th width="15%">Event Date</th><td>{{ $event->event_date }}</td>
                        </tr>
                        <tr>
                            <th>Event Name</th><td>{{ $event->event_name}}</td>
                        </tr>
                        <tr>
                            <th>Event Description</th><td>{{ $event->event_description}}</td>
                        </tr>
                        <tr>    
                            <th>Event Details</th><td>{{ $event->event_details}}</td>
                        </tr>
                        <tr>    
                            <th>Event Timezone</th><td>{{ $event->event_timezone}}</td>
                        </tr>
                        <tr>    
                            <th>Event Location</th><td>{{ $event->event_location}}</td>
                        </tr>
                        <tr>    
                            <th>Event Address 1</th><td>{{ $event->event_address1}}</td>
                        </tr>
                        <tr>    
                            <th>Event Address 2</th><td>{{ $event->event_address2}}</td>
                        </tr>
                        <tr>    
                            <th>Event City</th><td>{{ $event->event_city}}</td>
                        </tr>
                        <tr>    
                            <th>Event Url</th><td><a href="{{ $event->event_url}}">{{ $event->event_url}}</a></td>
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