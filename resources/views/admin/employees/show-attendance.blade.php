@extends('layouts.dashboard')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Employee | 
            <small>{{ ucwords($emp->firstname.' '.$emp->lastname) }} </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ BASE_URL }}/dashboard"><i class="fa fa-home"></i> Employee</a></li>
            <li>{{ ucwords($emp->firstname.' '.$emp->lastname) }} </li>
            <li class="active">Attendance</li>
        </ol>
    </section>

    @include('includes.dashboard.flash-message')


    <section class="content clearfix">

    
      @include('includes.dashboard.manage-employee-menu')
          <div class="col-md-9">
              <div class="col-md-12">
                <form action=" " method="get" >
                  <div class="box box-primary">
                      <div class="box-header ui-sortable-handle " style="cursor: move;">
                        <div class="box-body col-md-12">
                          <div class="form-group  col-sm-5">
                            <label class="col-sm-5">Start Date:<span class="text-danger">*</span></label>   
                            <input type="date" class=" col-sm-4 form-control" name="start_date" value="{{ $is_weekly ? '' : ''.$week_start }}"  >
                          </div>

                          <div class="form-group  col-md-5">
                            <label class="col-sm-5">End Date:<span class="text-danger">*</span></label>   
                            <input type="date" class=" col-sm-4 form-control" name="end_date" value="{{ $is_weekly ? '' : ''.$week_end }}"  >
                          </div>

                          <div class="form-group col-md-2 ">
                            <label class="col-sm-2">&nbsp</label>
                            <input type="submit" class="btn btn-primary submit pull-right" value="Submit Date"  />
                          </div>
                        </div>

                      </div>
                    </div>
                  </form>
              </div>  
            </div>
      @include('includes.dashboard.attendance-report')
    
    </section>
  

@endsection