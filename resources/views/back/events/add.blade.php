@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
             Event |
            <small>Add Event</small>
        </h1>

    </section>
    <ol class="breadcrumb">
        <li><a href="{{ BASE_URL }}/event"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Add Event</li>
    </ol>

        @if( $msg && !$error )
            <div class="col-sm-12" style="margin-top: 50px;">
                <div class="info-msg">
                    <div class="alert alert-success">
                        <strong>Success!</strong> <span class="msg"> <?php echo $msg ?></span>
                    </div>
                </div>
            </div>
        @endif

        @if( $msg && $error )
            <div class="col-sm-12" style="margin-top: 50px;">
                <div class="info-msg" >
                    <div class="alert alert-danger">
                        <strong>Error!</strong> <span class="msg"> <?php echo $msg ?></span>
                    </div>
                </div>
            </div>
        @endif

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

            <a href="/event" class="btn btn-primary submit">Back to List</a><br/><br/>

            {!! Form::open(array('novalidate'=> true, 'url' => 'event/add', 'class' => 'form', 'method' => 'post', 'files' => true)) !!}

                <div class="col-md-12">
                    <div class="col-md-4">
                        <ul class="img-list">
                          <li>
                            <img src="/images/uploads/event/logo/default.png" class="pull-left img-responsive img-thumbnail backend-img-size">
                            <span class="text-content"><span>Event Logo</span></span>
                          </li>
                        </ul>
                        <br/>
                        <br/>
                    </div>
                    <div class="col-md-5">
                            <ul class="img-list">
                              <li>
                                <img src="/images/uploads/event/banner/default.png" class="pull-left img-responsive img-thumbnail backend-img-size" >
                                <span class="text-content"><span>Event Banner</span></span>
                              </li>
                            </ul>
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
                    <label>Event Name</label><span class="text-danger">*</span>
                    <input type="text" value="{{ Input::get('event_name') }}" name="event_name" id="event_name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Event Start</label><span class="text-danger">*</span>

{{--                     <div class="input-group date form_datetime col-md-12" data-date-format="mm-dd-yyyy - HH:ii" data-link-field="dtp_input1">
                        <input class="form-control" size="16" type="text" value="{{ Input::get('event_date_start') }}" name="event_date_start" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div> --}}

                     <div class="col-md-12">
                        <div class="form-group">

                            <div class="col-md-4">
                                <select id="months" class="form-control" name="event_start_month" data-value="">
                                    @for( $i = 1; $i <= 12; $i++ )
                                        <option value="{{ $i }}"{{ (Input::get('event_start_month')==$i)? ' selected':'' }}>{{ $months[$i] }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select id="days" class="form-control" name="event_start_day" data-value="">
                                    @for( $i = 1; $i <= 31; $i++ )
                                        <option value="{{ $i }}"{{ (Input::get('event_start_day')==$i)? ' selected':'' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select id="years" class="form-control" name="event_start_year" data-value="">
                                    @for( $i = date('Y'); $i > date('Y') - 70; $i--)
                                        <option value="{{ $i }}"{{ (Input::get('event_start_year')==$i)? ' selected':'' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">

                            <div class="col-md-3">
                                Hours: <input class="form-control" type="number" max="24" min="0" maxlength="2" name="event_start_time_hour"
                                        value="{{ Input::get('event_start_time_hour') }}" placeholder="00" />
                            </div>
                            <div class="col-md-3">
                                Minutes: <input class="form-control" type="number" max="60" min="0" maxlength="2" name="event_start_time_min"
                                        value="{{ Input::get('event_start_time_min') }}" placeholder="00" />
                            </div>
                        </div>
                    </div>


                </div>

                <div class="form-group">
                    <label>Event End</label><span class="text-danger">*</span>

{{--                     <div class="input-group date form_datetime col-md-12" data-date-format="mm-dd-yyyy - HH:ii" data-link-field="dtp_input1">
                        <input class="form-control" size="16" type="text" value="{{ Input::get('event_date_end') }}" name="event_date_end" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                    </div> --}}

                     <div class="col-md-12">
                        <div class="form-group">

                            <div class="col-md-4">
                                <select id="months_end" class="form-control" name="event_end_month" data-value="">
                                    @for( $i = 1; $i <= 12; $i++ )
                                        <option value="{{ $i }}"{{ (Input::get('event_end_month')==$i)? ' selected':'' }}>{{ $months[$i] }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select id="days_end" class="form-control" name="event_end_day" data-value="">
                                    @for( $i = 1; $i <= 31; $i++ )
                                        <option value="{{ $i }}"{{ (Input::get('event_end_day')==$i)? ' selected':'' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select id="years_end" class="form-control" name="event_end_year" data-value="">
                                    @for( $i = date('Y'); $i > date('Y') - 70; $i--)
                                        <option value="{{ $i }}"{{ (Input::get('event_end_year')==$i)? ' selected':'' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">

                            <div class="col-md-3">
                                Hours: <input class="form-control" type="number" max="24" min="0" maxlength="2" name="event_end_time_hour"
                                        value="{{ Input::get('event_end_time_hour') }}" placeholder="00" />
                            </div>
                            <div class="col-md-3">
                                Minutes: <input class="form-control" type="number" max="60" min="0" maxlength="2" name="event_end_time_min"
                                        value="{{ Input::get('event_end_time_min') }}" placeholder="00" />
                            </div>

                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <label>Event Location</label><span class="text-danger">*</span>
                    <textarea name="event_location" class="form-control" required>{{ Input::get('event_location') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Event Country</label><span class="text-danger">*</span>
                    <select name="event_country" class="form-control" required>
                        <option>Select Country</option>
                        <?php foreach($countries as $country): ?>
                        <option value="<?php echo e($country->country_id); ?>" <?php echo $country->country_id == Input::get('event_country') ? 'selected' : '' ?>><?php echo e($country->country_name); ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Address Line 1</label><span class="text-danger">*</span>
                    <textarea name="event_address1"  class="form-control" required>{{ Input::get('event_address1') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Address Line 2</label>
                    <textarea name="event_address2"  class="form-control">{{ Input::get('event_address2') }}</textarea>
                </div>

                  <div class="form-group">
                    <label>Event City</label><span class="text-danger">*</span>
                    <input type="text" name="event_city" class="form-control" value="{{ Input::get('event_city') }}" required>
                </div>

                <div class="form-group">
                    <label>Event State/Province</label><span class="text-danger">*</span>
                    <input name="event_province" class="form-control" value="{{ Input::get('event_province') }}" required>
                </div>

                <div class="form-group">
                    <label>Zip Code</label><span class="text-danger">*</span>
                    <input type="text" name="event_postal" class="form-control" value="{{ Input::get('event_postal') }}" required>
                </div>


                <div class="form-group">
                    <label>Event Timezone</label><span class="text-danger">*</span>
                    <select name="event_timezone" class="form-control" required>
                        <option>Select Timezone</option>
                        <?php foreach($timezones as $timezone): ?>
                            <option value="<?php echo e($timezone->timezone_id); ?>" <?php echo $timezone->timezone_id == Input::get('event_timezone') ? 'selected' : '' ?> ><?php echo e($timezone->timezone_name); ?>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="col-md-6">

                <!--
                <div class="form-group">
                    <label>Event URL</label><span class="text-danger">*</span>
                    <input type="text" id="event_shortname" class="form-control" value="{{ Input::get('event_shortname') }}" disabled>
                    <input type="hidden" name="event_shortname" id="event_shortnames" class="form-control" value="{{ Input::get('event_shortname') }}">
                </div>
                -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Event Category</label><span class="text-danger">*</span>
                            <select name="category_id" class="form-control" id="category" required>
                                <option value="">Select Category</option>
                                <?php foreach($categories as $category): ?>
                                <option value="<?php echo ($category->id); ?>" <?php echo $category->id == Input::get('category_id') ? 'selected' : '' ?> ><?php echo e($category->category_name); ?>
                                <?php endforeach; ?>
                                <option value="other">Other</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-md-6" style="display:none;" id="event_other_category_name" >
                        <label>Other Category</label>
                        <div class="form-group">
                            <input type="text" name="event_other_category_name" class="form-control" value="{{ Input::get('event_other_category_name') }}" placeholder="Walking">
                            <input type="hidden" name="event_other_category" id="event_other_category" class="form-control" value="{{ Input::get('event_other_category') }}">
                        </div>
                    </div>
                </div>

{{--                 <div class="form-group">
                    <label>Event Province</label><span class="text-danger">*</span>
                    <input type="text" name="event_province" class="form-control" value="{{ Input::get('event_province') }}" required>
                </div> --}}

                <div class="form-group">
                    <label>Website</label>
                    <input type="text" name="event_url" class="form-control" id="event_url" value="{{ Input::get('event_url') }}" placeholder="www.example.com">
                </div>

                <div class="form-group">
                    <label>Event Description</label><span class="text-danger">*</span>
                    <textarea class="form-control" name="event_description" rows="10" maxlength="250" required>{{ Input::get('event_description') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Event Details</label><span class="text-danger">*</span>
                    <textarea class="form-control" name="event_details" rows="10" maxlength="250" required>{{ Input::get('event_details') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tags</label>
                            <ul class="tags-wrap clearfix">
                            <?php foreach($tags as $tag): ?>
                                <li>
                                    <label><input type="checkbox" class="" name="event_tag[]" value="{{ $tag->id }}" <?php echo $tag->id == Input::get('event_tag') ? 'checked' : '' ?>> <span class="label label-info"> {{ $tag->tag_url}} </span></label>
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
                                <input type="text" name="event_new_tag" id="tag-input" class="form-control" placeholder="Example: Fun Run">
                                <input type="hidden" name="event_new_tag_url" id="tag-input-url" class="form-control">
                            </div>

                            <div class="col-xs-2">
                                <input type="submit" data-token="{{ csrf_token() }}" class="btn btn-default add-tag-submit" name="" value="Add Tag">
                            </div>
                        </div>
                    </div>

                </div>


            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <input type="submit" class="btn btn-primary " value="Add Event!">
                </div>
            </div>

        </div>

            {!! Form::close() !!}

        </div>


    </section>
@endsection