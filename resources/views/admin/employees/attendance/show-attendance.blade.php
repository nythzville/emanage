@extends('layouts.dashboard')

@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <small>{{ ucwords($emp->firstname.' '.$emp->lastname) }} </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
            <li>{{ ucwords($emp->firstname.' '.$emp->lastname) }} </li>
            <li class="active">Attendance</li>
        </ol>
    </section>

    @include('includes.dashboard.flash-message')

    <section class="content clearfix">

    @include('includes.dashboard.attendance-report')

    <form action="" method="get" >
    <div class="col-md-3">
            <div class="box box-primary">

                <div class="box-header ui-sortable-handle" style="cursor: move;">
                  <i class="ion ion-clipboard"></i>
                  <h3 class="box-title">Actions </h3>
                </div>

                <div class="box-body">
                    <div class="row">
                      <div class="form-group  col-md-12">
                        <label>Start Date:</label><span class="text-danger">*</span>
                        <input type="date" class="form-control" name="start_date" value="{{ $is_weekly ? '' : ''.$week_start }}" placeholder="MM/DD/YYYY" >
                      </div>

                      <div class="form-group  col-md-12">
                        <label>End Date:</label><span class="text-danger">*</span>
                        <input type="date" class="form-control" name="end_date" value="{{ $is_weekly ? '' : '' .$week_end   }}" placeholder="MM/DD/YYYY" >
                      </div>

                      <div class="action">
                          <input type="submit" class="btn btn-primary submit pull-right" value="Submit Date"  />
                      </div>

                    </div>

                </div>
            </div>
    </div>
    </form>
 
    </section>
@endsection