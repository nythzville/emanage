@extends('layouts.admin-template')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>
        Employee Management
        <small>
            
        </small>
    </h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
            </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Employee<small>List</small></h2>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="employeesTable" class="table table-striped responsive-utilities jambo_table">
                            <thead>
                                <tr class="headings">
                                    <th>
                                        <input type="checkbox" class="tableflat">
                                    </th>
                                    <th>Employee ID </th>
                                    <th>Employee Name </th>
                                    <th>Position </th>
                                    <th>Contact</th>
                                    <th>Status </th>
                                    <th class=" no-link last"><span class="nobr">Action</span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $row_count = 0; ?>
                                @foreach($employees as $s_employee)

                                <tr class="<?php 
                                $row_count++;
                                if ( ($row_count%2) == 0 ) {
                                    echo 'even';
                                }else{
                                    echo 'odd';

                                }

                                ?> pointer">
                                    <td class="a-center ">
                                        <input type="checkbox" class="tableflat">
                                    </td>
                                    <td class=" ">{{ $s_employee->identification }}</td>
                                    <td class=" ">{{ $s_employee->firstname }} {{ $s_employee->lastname }}</td>
                                    <td class=" ">{{ $s_employee->job_title }}
                                    </td>
                                    <td class=" ">{{ $s_employee->mobile_no }} </td>
                                    <td class=" ">{{ $s_employee->employment_status }}</td>
                                    <td class=" last">
                                    <a href="{{ url() }}/admin/employee/{{ $s_employee->id }}/edit" class="btn btn-default btn-xs"><i class="fa fa-pencil"></i> Edit</a>
                                    <a href="{{ url() }}/admin/employee/{{ $s_employee->id }}/attendance" class="btn btn-info btn-xs"><i class="fa fa-eye"></i> Attendance</a>
                                    </td>
                                </tr>

                                @endforeach
                            
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

            <br />
            <br />
            <br />

        </div>
    </div>
        <!-- footer content -->
    <footer>
        <div class="">
            <p class="pull-right">Employee Management System Powered by <a>Mavericks</a>. |
                <span class="lead"> <i class="fa fa-thumbs-up"></i> Go Team!</span>
            </p>
        </div>
        <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->
        
    </div>
    <!-- /page content -->

@endsection