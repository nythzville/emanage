@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Event  |
            <small>{{ $event->event_name }}</small>
        </h1>

    </section>
    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/event"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Edit Event</li>
    </ol>

    @if( $msg && !$error )
        <div class="col-sm-12" style="margin-top: 50px;">
            <div class="info-msg">
                <div class="alert alert-success">
                    <strong>Succes!</strong> <span class="msg"><?php echo $msg ?></span>
                </div>
            </div>
        </div>
    @endif

    @if( $msg && $error )
        <div class="col-sm-12" style="margin-top: 50px;">
            <div class="info-msg" >
                <div class="alert alert-danger">
                    <strong>Error!</strong> <span class="msg"><?php echo $msg ?></span>
                </div>
            </div>
        </div>
    @endif

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
        <div class="col-md-12">
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
            <a href="/event/add" class="btn btn-primary submit pull-right"><i class="fa fa-plus"></i> Add New Event</a>
            <br/><br/>
                {!! Form::open( array('novalidate'=> true,'id'=>'form-edit-event', 'method'=>'post', 'files' => true) ) !!}

                <div class="col-md-12">
                    <div class="col-md-4">
                        @if( !$event->event_image )
                        <ul class="img-list">
                          <li>
                            <img src="/images/uploads/event/logo/default.png" class="pull-left img-responsive img-thumbnail backend-img-size">
                            <span class="text-content"><span>Event Logo</span></span>
                          </li>
                        </ul>
                        @else
                        <ul class="img-list">
                          <li>
                            <img src="/images/uploads/event/logo/{{$event->event_image}}" class="pull-left img-responsive img-thumbnail backend-img-size" style="">
                            <span class="text-content"><span>Event Logo</span></span>
                          </li>
                        </ul>
                        @endif
                        <br/>
                        <br/>
                    </div>
                    <div class="col-md-5">
                        @if( !$event->event_banner )
                            <ul class="img-list">
                              <li>
                                <img src="/images/uploads/event/banner/default.png" class="pull-left img-responsive img-thumbnail backend-img-size" >
                                <span class="text-content"><span>Event Banner</span></span>
                              </li>
                            </ul>
                        @else
                            <ul class="img-list">
                              <li>
                                <img src="/images/uploads/event/banner/{{$event->event_banner}}" class="pull-left img-responsive img-thumbnail backend-img-size" >
                                <span class="text-content"><span>Event Banner</span></span>
                              </li>
                            </ul>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <div class="col-md-12">
                            <label>Event Logo</label>
                            <input type="file" name="event_image">
                                <br/>
                            <label>Event Banner</label>
                            <input type="file" name="event_banner">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Event Name</label>
                        <input type="text" value="{{ $event->event_name }}" name="event_name" id="event_name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Event Start</label>

{{--                         <div class="input-group date form_datetime col-md-12" data-date-format="yyyy-mm-dd - HH:ii:ss" data-link-field="dtp_input1">
                            <input class="form-control" size="16" type="text" value="{{ date('Y-m-d - H:i:s', strtotime($event->event_date_start) ) }}" name="event_date_start">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        </div> --}}

                         <div class="col-md-12">
                            <div class="form-group">

                                <div class="col-md-4">
                                    <select id="months" class="form-control" name="event_start_month">
                                        @for( $i = 1; $i <= 12; $i++ )
                                            <option value="{{ $i }}"{{ (date('F', strtotime($event->event_date_start) )==$months[$i])? ' Selected':'' }}>{{ $months[$i] }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select id="days" class="form-control" name="event_start_day">
                                    @for( $i = 1; $i <= 31; $i++ )
                                        <option value="{{ $i }}"{{ (date('d', strtotime($event->event_date_start) )==$i)? ' Selected':'' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                                </div>

                                <div class="col-md-3">
                                    <select id="years" class="form-control" name="event_start_year">
                                        @for( $i = date('Y'); $i > date('Y') - 70; $i--)
                                            <option value="{{ $i }}"{{ (date('Y', strtotime($event->event_date_start) )==$i)? ' Selected':'' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">

                                <div class="col-md-3">
                                    Hours: <input class="form-control" type="number" max="24" min="0" maxlength="2"
                                    name="event_start_time_hour" placeholder="00" value="{{ date('H', strtotime($event->event_date_start) ) }}" />
                                </div>
                                <div class="col-md-3">
                                    Minutes: <input class="form-control" type="number" max="60" min="0" maxlength="2"
                                    name="event_start_time_min" placeholder="00" value="{{ date('i', strtotime($event->event_date_start) ) }}" />
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label>Event End</label>

{{--                         <div class="input-group date form_datetime col-md-12" data-date-format="yyyy-mm-dd - HH:ii:ss" data-link-field="dtp_input1">
                            <input class="form-control" size="16" type="text" value="{{ date('Y-m-d - H:i:s', strtotime($event->event_date_end) ) }}" name="event_date_end">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        </div> --}}

                         <div class="col-md-12">
                            <div class="form-group">

                                <div class="col-md-4">
                                    <select id="months_end" class="form-control" name="event_end_month">
                                        @for( $i = 1; $i <= 12; $i++ )
                                            <option value="{{ $i }}"{{ (date('F', strtotime($event->event_date_end) )==$months[$i])? ' Selected':'' }}>{{ $months[$i] }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select id="days_end" class="form-control" name="event_end_day">
                                        @for( $i = 1; $i <= 31; $i++ )
                                            <option value="{{ $i }}"{{ (date('d', strtotime($event->event_date_end) )==$i)? ' Selected':'' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select id="years_end" class="form-control" name="event_end_year">
                                        @for( $i = date('Y'); $i > date('Y') - 70; $i--)
                                            <option value="{{ $i }}"{{ (date('Y', strtotime($event->event_date_end) )==$i)? ' Selected':'' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">

                                <div class="col-md-3">
                                    Hours: <input class="form-control" type="number" max="24" min="0" maxlength="2"
                                    name="event_end_time_hour" placeholder="00" value="{{ date('H', strtotime($event->event_date_end) ) }}"/>
                                </div>
                                <div class="col-md-3">
                                    Minutes: <input class="form-control" type="number" max="60" min="0" maxlength="2"
                                    name="event_end_time_min" placeholder="00" value="{{ date('i', strtotime($event->event_date_end) ) }}" />
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label>Event Location</label>
                        <textarea name="event_location" class="form-control">{{ $event->event_location }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Event Country</label>
                        <select name="event_country" class="form-control">
                            <option>Select Country</option>
                            <?php foreach($countries as $country): ?>
                            <option value="<?php echo e($country->country_id); ?>" <?php echo $country->country_id == $event->event_country ? 'selected' : '' ?>><?php echo e($country->country_name); ?>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Address Line 1</label>
                        <textarea name="event_address1"  class="form-control">{{ $event->event_address1 }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Address Line 2</label>
                        <textarea name="event_address2"  class="form-control">{{ $event->event_address2 }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Event City</label>
                        <input type="text" name="event_city" class="form-control" value="{{ $event->event_city }}">
                    </div>

                    <div class="form-group">
                        <label>Event State/Province</label>
                        <input name="event_province" class="form-control" value="{{ $event->event_province }}">
                    </div>


                    <div class="form-group">
                        <label>Zip Code</label>
                        <input type="text" name="event_postal" class="form-control" value="{{ $event->event_postal }}">
                    </div>


                    <div class="form-group">
                        <label>Event Timezone</label>
                        <select name="event_timezone" class="form-control">
                            <option>Select Timezone</option>
                            <?php foreach($timezones as $timezone): ?>
                                <option value="<?php echo e($timezone->timezone_id); ?>" <?php echo $timezone->timezone_id == $event->event_timezone ? 'selected' : '' ?> ><?php echo e($timezone->timezone_name); ?>
                            <?php endforeach; ?>
                        </select>
                    </div>


                </div>

                <div class="col-md-6">
                    <!--
                    <div class="form-group">
                        <label>Event Shortname</label>
                        <input type="text" id="event_shortname" class="form-control" value="{{ $event->event_shortname }}" disabled>
                        <input type="hidden" name="event_shortname" id="event_shortnames" class="form-control" value="{{ $event->event_shortname }}">
                    </div>
                    -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Event Category</label>
                                <select name="category_id" class="form-control" id="category">
                                    <option value="">Select Category</option>
                                    <?php foreach($categories as $category): ?>
                                    <option value="<?php echo ($category->id); ?>" <?php echo $category->id == $category->id ? 'selected' : '' ?> ><?php echo e($category->category_name); ?>
                                    <?php endforeach; ?>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-md-6" style="display:none;" id="event_other_category_name" >
                            <label>Other Category</label>
                            <div class="form-group">
                                <input type="text" name="event_other_category_name" id="event_other_category_name2" class="form-control" value="{{ Input::get('event_other_category_name') }}" placeholder="Walking">
                                <input type="hidden" name="event_other_category" id="event_other_category" class="form-control" value="{{ Input::get('event_other_category') }}">
                            </div>
                        </div>


                    </div>

{{--                     <div class="form-group">
                        <label>Event Province</label>
                        <input type="text" name="event_province" class="form-control" value="{{ $event->event_province }}">
                    </div> --}}

                    <div class="form-group">
                        <label>Website</label>
                        <input type="text" name="event_url" class="form-control" id="event_url" value="{{ $event->event_url }}">
                    </div>

                    <div class="form-group">
                        <label>Event Description</label>
                        <textarea class="form-control" id="event_description" name="event_description" maxlength="250" rows="10">{{ $event->event_description }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Event Details</label>
                        <textarea class="form-control" id="event_details" name="event_details" maxlength="250" rows="10">{{ $event->event_details }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tags</label>
                                <ul class="tags-wrap clearfix">
                                <?php foreach($tags as $tag): ?>
                                    <li>
                                        <input type="checkbox" class="" name="event_tag[]" value="{{ $tag->id }}" <?php foreach($event_tags as $event_tag ) { echo $tag->id == $event_tag->tag_id ? 'checked' : ''; } ?>> <span class="label label-info"> {{ $tag->tag_url}} </span>
                                    </li>
                                <?php endforeach; ?>
                                </ul>

                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="row">

                                <div class="col-sm-12" >
                                    <div class="info-msg-tag" style="display:none;">
                                        <div class="alert alert-success">
                                            <strong>Success!</strong> <span class="msg"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12" >
                                    <div class="info-msg-tag" style="display:none;">
                                        <div class="alert alert-danger">
                                            <strong>Error!</strong> <span class="msg"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-10">
                                    <input type="text" name="event_new_tag" id="tag-input" class="form-control">
                                </div>

                                <div class="col-xs-2">
                                    <input type="submit" data-token="{{ csrf_token() }}" class="btn btn-default add-tag-submit" name="" value="Add Tag">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Update Event!">
                    </div>

                </div>

                {!! Form::close() !!}

        </div>

    </section>
@endsection