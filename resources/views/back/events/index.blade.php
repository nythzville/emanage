@extends('layouts.dashboard')

@section('content')
	<!-- Content Header (Page header) -->

    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/event"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Events</li>
    </ol>

    <div class="col-sm-12">
        @if(Session::has('flash_notice'))
            <div class="info-msg">
                <div class="alert alert-success">
                    <strong>Success!</strong> <span class="msg">{{ Session::get('flash_notice') }}</span>
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

            <div class="row">
                <div class="buttons col-sm-6"> 
                    @if( Auth::user()->user_type == 'organizer' )
                        <a href="event/add" class="btn btn-primary submit">Add Event</a>
                    @endif
                    <a href="/export/organizer_events" class="btn btn-primary submit">Export CSV - My Events</a>
                </div>
                <div class="col-sm-6 text-right">
                    {!! Form::open( array('id'=>'form-search', 'method'=>'get') ) !!}
                        <div class="input-group">
                            <input type="hidden" name="perpage" value="{{$events->perPage() }}">
                            <input type="text" class="form-control" name="q" placeholder="Search event..." value="{{Input::get('q')}}">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit"><span class="fa fa-search"></span> Search</button>
                            </span>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="row">
                <div id="filter-panel" class="col-sm-3" style="margin:10px 0">
                    {!! Form::open(array('method'=>'GET', 'style'=>'margin-top: 10px;')) !!}
                        <input type="hidden" name="q" value="{{Input::get('q')}}">
                        <div class="input-group">
                            <span class="input-group-addon">Row per page</span>
                            <select id="perpage" name="perpage" class="form-control">
                                <?php 
                                    $perpages = array(1,2,10,15,120,30,40,50,100);
                                ?>
                                @foreach($perpages as $perpage )
                                    <option value="{{$perpage}}" {{ $events->perPage() == $perpage ? 'selected' : '' }}>{{$perpage}}</option>
                                @endforeach
                            </select>          
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Go!</button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="col-sm-9 text-right">
                    <?php echo $events->appends( Input::except('page') )->render() ?>
                </div>
            </div>

            <br/ >
            <div class="box">
                <div class="box-body no-padding">
                  <table class="table table-condensed">
                    <tbody>
                        <tr class="tbl-head">
                        @if( Auth::user()->user_type == 'admin' )
                            <th style="width:15%">Event Organizer</th>
                        @endif
                        <th style="width:20%">Event Date</th>
                        <th>Event Name</th>
                        <th style="width:33%" colspan="2">Actions</th>
                        </tr>
                    </tbody>
                        <?php $cnt = 1 ?>
                        @forelse( $events as $event )
                            <tr class="{{ $cnt++ % 2 == 0 ? 'even':'' }}" >
                                @if( Auth::user()->user_type == 'admin' ) 
                                    <td>{{ $event->user->user_firstname}} {{ $event->user->user_lastname}}</td>
                                @endif
                                <td style="width:15%;"><b>Start:</b> {{ date('M d Y - H:i:s', strtotime($event->event_date_start) ) }}<br/><b>End:</b> {{ date('M d Y - H:i:s', strtotime($event->event_date_end) ) }}</td>
                                <td style="width:20%;">{{ $event->event_name}}</td>
                                <td style="width:40%;">
                                    <a href="{{ BASE_URL }}/event/detail/{{ $event->id }}" class="btn btn-success" title="View Details">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                    <a href="{{ BASE_URL }}/event/{{ $event->id }}/participants" class="btn btn-primary" title="View Participants">
                                        <i class="fa fa-users"></i> Participants
                                    </a>
                                    <a href="{{ BASE_URL }}/event/edit/{{ $event->id }}" class="btn btn-default" title="Edit Event">
                                       <i class="fa fa-pencil-square-o"></i> Edit
                                    </a>
                                    <a href="{{ BASE_URL }}/event/delete/{{ $event->id }}" class="btn btn-danger" title="Delete Event">
                                       <i class="fa fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4">Sorry, no event to be displayed.</td></tr>
                        @endforelse
                   </table>
                </div><!-- /.box-body -->
            </div>

            <div class="text-right">
                <?php echo $events->appends( Input::except('page') )->render() ?>
            </div>

        </div>

    </section>
@endsection