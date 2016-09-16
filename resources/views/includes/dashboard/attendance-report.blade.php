<div class="col-md-9">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header ui-sortable-handle " style="cursor: move;">
              <i class="ion ion-clipboard"></i>
              <h3 class="box-title">{{ $is_weekly ? 'Weekly': ''}} Attendance Report</h3>
              <h3 class="box-title">{{ $is_weekly ? '' : 'From: '.date('F d, Y',strtotime($week_start))}}</h3> 
              <h3 class="box-title">{{ $is_weekly ? '' : 'To: '  .date('F d, Y',strtotime($week_end))}} </h3>

              

            </div><!-- /.box-header -->

            <div class="box-body">
              <ul class="todo-list ui-sortable">
                <?php 
                      $total_lates = 0; 
                      $total_undertime = 0; 
                      $total_early = 0;
                      $total_overtime = 0; 
                    ?>
                    @foreach( $weekly_attendance as $attendance )
                        <li>
                          <!-- drag handle -->
                          <span class="handle ui-sortable-handle">
                            <i class="fa fa-ellipsis-v"></i>
                            <i class="fa fa-ellipsis-v"></i>
                          </span>
                          <!-- todo text -->
                          <span class="text">{{ ucfirst($attendance->day) }}</span>
                          <!-- Check if EARLY -->
                          @if( $attendance->early )
                            <?php $total_early += $attendance->early; ?>
                            <small class="label label-success">EARLY: {{ seconds_to_words( $attendance->early ) }}</small>
                          @endif
                          <!-- Check if ABSENT -->
                          @if( $attendance->absent )
                            <small class="label label-danger">ABSENT</small>
                          @endif
                          <!-- Check if LATE -->
                          @if( $attendance->lates )
                            <?php $total_lates += $attendance->lates; ?>
                            <small class="label label-warning">LATE: {{ seconds_to_words( $attendance->lates ) }}</small>
                          @endif
                          <!-- Check if UNDERTIME -->
                          @if( $attendance->undertime )
                            <?php $total_undertime += $attendance->undertime; ?>
                            <small class="label label-warning">UNDERTIME: {{ seconds_to_words( $attendance->undertime ) }}</small>
                          @endif
                          @if( $attendance->overtime )
                            <?php $total_overtime += $attendance->overtime; ?>
                            <small class="label label-success">OVERTIME: {{ seconds_to_words( $attendance->overtime ) }}</small>
                          @endif
                        </li>
                    @endforeach
               
              </ul>
            </div><!-- /.box-body -->
            
            <div class="box-footer clearfix no-border">
                <div class="box-footer clearfix no-border">
                    <div class="col-xs-3"><span class="bold">Total Early :</span> 
                        <div>{{ seconds_to_words( $total_early ) }}</div>
                    </div>
                    <div class="col-xs-3"><span class="bold">Total Lates :</span>
                        <div>{{ seconds_to_words( $total_lates ) }}</div>
                    </div>
                    <div class="col-xs-3"><span class="bold">Total Undertime :</span> 
                        <div>{{ seconds_to_words( $total_undertime ) }}</div>
                    </div>
                    <div class="col-xs-3"><span class="bold">Total Overtime :</span> 
                        <div>{{ seconds_to_words( $total_overtime ) }}</div>
                    </div>
                </div>
            </div>
          </div>
    </div> 
</div>