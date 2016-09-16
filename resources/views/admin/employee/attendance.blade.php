@extends('layouts.admin-template')

@section('content')

<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="page-title">
            <div class="title_left">
                <h3>
                    {{ $employee->firstname }} {{ $employee->lastname }}
                    <small>
                        Empoyee Attendance
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
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Calender of Attendance <small>Sessions</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div id='calendar'></div>

                    </div>
                </div>
            </div>
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


<!-- Start Calender modal -->
<div id="CalenderModalNew" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">New Calender Entry</h4>
            </div>
            <div class="modal-body">
                <div id="testmodal" style="padding: 5px 20px;">
                    <form id="antoform" class="form-horizontal calender" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" style="height:55px;" id="descr" name="descr"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary antosubmit">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div id="CalenderModalEdit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel2">Edit Calender Entry</h4>
            </div>
            <div class="modal-body">

                <div id="testmodal2" style="padding: 5px 20px;">
                    <form id="antoform2" class="form-horizontal calender" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title2" name="title2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" style="height:55px;" id="descr2" name="descr"></textarea>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default antoclose2" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary antosubmit2">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div id="fc_create" data-toggle="modal" data-target="#CalenderModalNew"></div>
<div id="fc_edit" data-toggle="modal" data-target="#CalenderModalEdit"></div>

<!-- End Calender modal -->
<!-- /page content -->

<script src="{{ url() }}/js/moment.min.js"></script>

<script src="{{ url() }}/js/calendar/fullcalendar.min.js"></script>
<script>
$(window).load(function () {

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var started;
    var categoryClass;

    var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        selectable: false,
        selectHelper: false,
        select: function (start, end, allDay) {
            // $('#fc_create').click();

            // started = start;
            // ended = end

            // $(".antosubmit").on("click", function () {
            //     var title = $("#title").val();
            //     if (end) {
            //         ended = end
            //     }
            //     categoryClass = $("#event_type").val();

            //     if (title) {
            //         calendar.fullCalendar('renderEvent', {
            //                 title: title,
            //                 start: started,
            //                 end: end,
            //                 allDay: allDay
            //             },
            //             true // make the event "stick"
            //         );
            //     }
            //     $('#title').val('');
            //     calendar.fullCalendar('unselect');

            //     $('.antoclose').click();

            //     return false;
            // });
        },
        eventClick: function (calEvent, jsEvent, view) {
            //alert(calEvent.title, jsEvent, view);

            // $('#fc_edit').click();
            // $('#title2').val(calEvent.title);
            // categoryClass = $("#event_type").val();

            // $(".antosubmit2").on("click", function () {
            //     calEvent.title = $("#title2").val();

            //     calendar.fullCalendar('updateEvent', calEvent);
            //     $('.antoclose2').click();
            // });
            // calendar.fullCalendar('unselect');
        },
        editable: false,
        events: [
        
        @foreach($calendar_attendance as $attendance)
            {
                title: '{{ $attendance->status }}',
                start: new Date('{{ $attendance->login_time }}'),
                end: new Date('{{ $attendance->logout_time}}')
        },
        @endforeach
    ]
    });
});
</script>
@endsection