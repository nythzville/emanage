       </div>

    </div>

    <div class="modal" id="time-in-modal" aria-hidden="false" aria-labelledby="time-in-modal-label" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="time-in-form" action="" method="post">
                    
        
                </form>
            </div>
        </div>
    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="{{ url() }}/js/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="{{ url() }}/js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="{{ url() }}/js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="{{ url() }}/js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="{{ url() }}/js/icheck/icheck.min.js"></script>

    <script src="{{ url() }}/js/custom.js"></script>

    @if(($what=='create_employee') | ($action=='update') | ($what=='Dashboard'))
    
    <!-- switchery -->
    <script src="{{ url() }}/js/switchery/switchery.min.js"></script>
    
    <!-- daterangepicker -->
    <script type="text/javascript" src="{{ url() }}/js/moment.min2.js"></script>
    <script type="text/javascript" src="{{ url() }}/js/datepicker/daterangepicker.js"></script>

    @endif

    @if($what=='Dashboard')

    <!-- flot js -->
    <!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->
    <script type="text/javascript" src="{{ url() }}/js/flot/jquery.flot.js"></script>
    <script type="text/javascript" src="{{ url() }}/js/flot/jquery.flot.pie.js"></script>
    <script type="text/javascript" src="{{ url() }}/js/flot/jquery.flot.orderBars.js"></script>
    <script type="text/javascript" src="{{ url() }}/js/flot/jquery.flot.time.min.js"></script>
    <script type="text/javascript" src="{{ url() }}/js/flot/date.js"></script>
    <script type="text/javascript" src="{{ url() }}/js/flot/jquery.flot.spline.js"></script>
    <script type="text/javascript" src="{{ url() }}/js/flot/jquery.flot.stack.js"></script>
    <script type="text/javascript" src="{{ url() }}/js/flot/curvedLines.js"></script>
    <script type="text/javascript" src="{{ url() }}/js/flot/jquery.flot.resize.js"></script>


    <!-- flot -->
    <script type="text/javascript">

    function plot(chartMinDate, chartMaxDate){

        //define chart clolors ( you maybe add more colors if you want or flot will add it automatic )
        var chartColours = ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'];

        //generate random number for charts
        randNum = function () {
            return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
        }

        $(function () {
            var d1 = [];
            //var d2 = [];

            //here we generate data for chart
            //for (var i = 0; i < 30; i++) {
                //d1.push([new Date(Date.today().add(i).days()).getTime(), randNum() + i + i + 10]);
            @foreach($attendance_count as $attendance)    
            
                d1.push([new Date('{{ $attendance->login_time_reference }}'), {{ $attendance->present }} ]);
            
            @endforeach    
                //    d2.push([new Date(Date.today().add(i).days()).getTime(), randNum()]);

            //}

            //var chartMinDate = d1[0][0]; //first day
            // var chartMaxDate = d1[20][0]; //last day

            //chartMaxDate = new Date();

            var tickSize = [1, "day"];
            var tformat = "%d/%m/%y";

            //graph options
            var options = {
                grid: {
                    show: true,
                    aboveData: true,
                    color: "#3f3f3f",
                    labelMargin: 10,
                    axisMargin: 0,
                    borderWidth: 0,
                    borderColor: null,
                    minBorderMargin: 5,
                    clickable: true,
                    hoverable: true,
                    autoHighlight: true,
                    mouseActiveRadius: 100
                },
                series: {
                    lines: {
                        show: true,
                        fill: true,
                        lineWidth: 2,
                        steps: false
                    },
                    points: {
                        show: true,
                        radius: 4.5,
                        symbol: "circle",
                        lineWidth: 3.0
                    }
                },
                legend: {
                    position: "ne",
                    margin: [0, -25],
                    noColumns: 0,
                    labelBoxBorderColor: null,
                    labelFormatter: function (label, series) {
                        // just add some space to labes
                        return label + '&nbsp;&nbsp;';
                    },
                    width: 40,
                    height: 1
                },
                colors: chartColours,
                shadowSize: 0,
                tooltip: true, //activate tooltip
                tooltipOpts: {
                    content: "%s: %y.0",
                    xDateFormat: "%d/%m",
                    shifts: {
                        x: -30,
                        y: -50
                    },
                    defaultTheme: false
                },
                yaxis: {
                    min: 0
                },
                xaxis: {
                    mode: "time",
                    minTickSize: tickSize,
                    timeformat: tformat,
                    min: chartMinDate,
                    max: chartMaxDate
                }
            };
            var plot = $.plot($("#placeholder33x"), [{
                label: "Attendance",
                data: d1,
                lines: {
                    fillColor: "rgba(150, 202, 89, 0.12)"
                }, //#96CA59 rgba(150, 202, 89, 0.42)
                points: {
                    fillColor: "#fff"
                }
            }], options);
        });

    }

    plot(moment('01/01/2016'), new Date() );
    </script>
    <!-- /flot -->
    
     <!-- datepicker -->
    <script type="text/javascript">
        $(document).ready(function () {

            var cb = function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
            }

            var optionSet1 = {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2016',
                maxDate: new Date(),
                dateLimit: {
                    days: 60
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'left',
                buttonClasses: ['btn btn-default'],
                applyClass: 'btn-small btn-primary',
                cancelClass: 'btn-small',
                format: 'MM/DD/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Clear',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            };
            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#reportrange').daterangepicker(optionSet1, cb);
            $('#reportrange').on('show.daterangepicker', function () {
                console.log("show event fired");
            });
            $('#reportrange').on('hide.daterangepicker', function () {
                console.log("hide event fired");
            });
            $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
                // console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
                plot(picker.startDate, picker.endDate);                

            });
            $('#reportrange').on('cancel.daterangepicker', function (ev, picker) {
                console.log("cancel event fired");
            });
            $('#options1').click(function () {
                $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
            });
            $('#options2').click(function () {
                $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
            });
            $('#destroy').click(function () {
                $('#reportrange').data('daterangepicker').remove();
            });
        });
    </script>
    <!-- /datepicker -->


    @endif

    @if($what=='employeesList')
    <!-- Datatables -->
    <script src="{{ url() }}/js/datatables/js/jquery.dataTables.js"></script>
    <script src="{{ url() }}/js/datatables/tools/js/dataTables.tableTools.js"></script>
    <script>
        $(document).ready(function () {
            $('input.tableflat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });

        var asInitVals = new Array();
        $(document).ready(function () {
            var oTable = $('#employeesTable').dataTable({
                "oLanguage": {
                    "sSearch": "Search all columns:"
                },
                "aoColumnDefs": [
                    {
                        'bSortable': false,
                        'aTargets': [0]
                    } //disables sorting for column one
        ],
                'iDisplayLength': 12,
                "sPaginationType": "full_numbers",
                "dom": 'T<"clear">lfrtip',
                "tableTools": {
                    "sSwfPath": "{{ asset('js/datatables/tools/swf/copy_csv_xls_pdf.swf') }}"
                }
            });
            $("tfoot input").keyup(function () {
                /* Filter on the column based on the index of this element's parent <th> */
                oTable.fnFilter(this.value, $("tfoot th").index($(this).parent()));
            });
            $("tfoot input").each(function (i) {
                asInitVals[i] = this.value;
            });
            $("tfoot input").focus(function () {
                if (this.className == "search_init") {
                    this.className = "";
                    this.value = "";
                }
            });
            $("tfoot input").blur(function (i) {
                if (this.value == "") {
                    this.className = "search_init";
                    this.value = asInitVals[$("tfoot input").index(this)];
                }
            });
        });
    </script>
    @endif

</body>

</html>