<?php namespace App\Http\Controllers;

use Validator;
use Input;
use Crypt;
use Eloquent;
use Response;
use URL;
use Mail;
use Auth;
use Redirect;
use Config;
use Request;
use File;
use Image;
use Session;
use Hash;

use App\Leaves;
use App\Post;
use App\Employee;
use App\Department;
use App\AttendanceReference;
use App\Attendance;

class EmployeeController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | AUTHOR: ryandejandobinas@gmail.com
    | EMPLOYEE MANAGEMENT CONTROLLER
    |--------------------------------------------------------------------------
    |
    */

    private $employee_mgnt = array(
                    'profile',
                    'personal_information',
                    'account_details',
                    'work_details',
                    'profile_image',
                    'attendance_reference',
                    'attendance',
                    'attendance_report',
                    'leave_form',
                    'dashboard'
                );

    public function __construct()
    {
        $this->params = array(
            'error' => false,
            'redirect' => false,
            'redirect_to' => '/',
            'msg' => '',
            'ride'=>'',
            'mainmenu' => 'employee',
            'menu_action' => 'index'
        );

        $this->params['week_days'] = array(
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
        );

        $this->current_user = $this->params['current_user'] = Auth::user();
    }


    public function profile()
    {

        $week_start = date('Y-m-d 00:00:00',$this->week_date(date("W"), 0 ) );
        $week_end = date('Y-m-d 00:00:00',$this->week_date(date("W"), 6 ) );

        /* 

        Weekly Attendance 

        */
        $weekly_attendance = array(
            'Mon'   => (object) array(
                      'day' => 'monday',
                      ),
            'Tue'   => (object) array(
                      'day' => 'tuesday',
                      ),
            'Wed'   => (object) array(
                      'day' => 'wednesday',
                      ),
            'Thu'   => (object) array(
                      'day' => 'thursday',
                      ),
            'Fri'   => (object) array(
                      'day' => 'friday',
                      ),

            );

        $attendances = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND login_time_reference <= ?', array( $this->current_user->employee->id, $week_start, $week_end) )->get();

        $total_lates = 0;
        $total_early = 0;
        $total_overtime = 0;
        $total_undertime = 0;


        foreach ($weekly_attendance as $day => $value) {
            

            foreach ($attendances as $attendance) {
                
                

                if( $value->day == $attendance->day){

                    $weekly_attendance[$day] = $attendance;
                    $total_lates += $attendance->lates;
                    $total_early += $attendance->early;
                    $total_overtime += $attendance->overtime;
                    $total_undertime += $attendance->undertime;

                    break;
                
                }else{

                    $weekly_attendance[$day] = null;
                }                
            }
        }
        
    
        
        $weekly_report['total_lates'] = $total_lates;
        $weekly_report['total_early'] = $total_early;
        $weekly_report['total_overtime'] = $total_overtime;
        $weekly_report['total_undertime'] = $total_undertime;

        $this->params['weekly_report'] = $weekly_report;
        $this->params['weekly_attendance'] = $weekly_attendance;
        //$this->params['attendance_reference'] = $this->current_user->employee->attendance_reference->where('disabled', '=', 0);
        $this->params['what'] = 'profile';
        $this->params['departments'] = Department::all();

        return view('employees.show-profile', $this->params);
    }



    public function attendance_login()
    {

        $day = strtolower( date('l') );
        // Get attendance reference on this day
        $attendance_reference = AttendanceReference::whereRaw('employee_id = ? AND day = ?', array( $this->employee->id , $day) )->first();
        if( !$attendance_reference ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'Sorry but you don\'t have attendance time reference in the record.';
            return Response::json($this->params);
        }

        // Assign login time
        $login_time = time();
        $login_date_time = date('Y-m-d H:i:s');
        
        $login_REF_date_time = date('Y-m-d '.$attendance_reference->login_time_reference);
        $login_REF_time = strtotime( $login_REF_date_time );

        $logout_REF_date_time = date('Y-m-d '.$attendance_reference->logout_time_reference);
        $logout_REF_time = strtotime( $logout_REF_date_time );

        $current_start_time = date('Y-m-d 00:00:00');
        $current_end_time = date('Y-m-d 23:59:59');


        //$leaves = Leaves::all();
        // Check if there's already attendace record exist
        $attendance = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND login_time_reference <= ?', array($this->employee->id, $current_start_time, $current_end_time) )->first();


        if( $attendance ) {
            // Check if is on leave
            if( $attendance->on_leave ) {
                $this->params['error'] = true;
                $this->params['msg'] = 'Sorry but you are currently on leave.';
                return Response::json($this->params);
            }

            // Check if employee has logged in already
            if( $attendance->login_time != '0000-00-00 00:00:00' && $attendance->login_time ) {
                $this->params['error'] = true;
                $this->params['msg'] = 'Sorry but you already logged in recently at '.$attendance->login_time.'.';
                return Response::json($this->params);

            } else {
                // reference the stored attendance record time references
                $login_REF_date_time = $attendance->login_time_reference;
                $login_REF_time = strtotime( $login_REF_date_time );

                $logout_REF_date_time = $attendance->logout_time_reference;
                $logout_REF_time = strtotime( $logout_REF_date_time );
            }
        } else {

            // Create new attendance default record
            $attendance = new Attendance();
            $attendance->employee_id = $this->employee->id;
            // $attendance->login_time = $login_date_time;
            // $attendance->logout_time = $login_date_time;
            $attendance->login_time = '0000-00-00 00:00:00';
            $attendance->logout_time = '0000-00-00 00:00:00';
            $attendance->break_time = '0000-00-00 00:00:00';
            $attendance->stopbreak_time = '0000-00-00 00:00:00';
            $attendance->lates = 0;
            $attendance->early = 0;
            $attendance->undertime = 0;
            $attendance->overtime = 0;
            $attendance->break = 0;
            $attendance->day = $day;
            $attendance->login_time_reference = $login_REF_date_time;
            $attendance->logout_time_reference = $logout_REF_date_time;
            $attendance->absent = 1;
            $attendance->status = 'ABSENT';
            $attendance->save();
        }

        // Check if login time is not greater than logout time
        if( $login_time > $logout_REF_time ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'Sorry but you are only allowed to login after '.$logout_REF_date_time.'.';
            $attendance->login_time = $login_date_time;
            $attendance->logout_time = $login_date_time;
            $attendance->save();
            return Response::json($this->params);
        }

        // Check if he is late
        if( $login_time > $login_REF_time ) {
            $this->params['msg'] = 'You have successfully logged in but you are late.';
            $this->params['status'] = 'LATE';
            $this->params['ride'] = $login_date_time;
            $lates = $login_time - $login_REF_time;
            $attendance->lates = $lates;

        } elseif($login_time < $login_REF_time) {
            $this->params['msg'] = 'You have successfully logged in and you are early. Keep it up! ';
            $this->params['status'] = 'EARLY';
            $early = $login_REF_time - $login_time;
            $attendance->early = $early;
            
        }else{
            $this->params['msg'] = 'You have successfully logged in. ';
            $this->params['status'] = 'ONTIME';
        }

        // $post = new Post();
        // $post->body = 'logged in';
        // $post->employee_id = Auth::user()->id;
        // $post->created_at = $login_date_time;
        // $post->save();

        $attendance->login_time = $login_date_time;
        $attendance->day = $day;
        $attendance->absent = 0;
        $attendance->status = $this->params['status'];
        $attendance->save();

        $this->params['attendance'] = $attendance;
        $this->params['error'] = false;
        return Response::json($this->params);

    }

    /*
    |--------------------------------------------------------------------------
    | ADDED BY: JOHN EIMAN MISSION
    | BREAK, END BREAK FUNCTIONS
    |--------------------------------------------------------------------------
    |
    */
    public function attendance_break(){
        $day = strtolower( date('l') );
        $current_start_time = date('Y-m-d 00:00:00');
        $current_end_time = date('Y-m-d 23:59:59');
        $attendance = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND login_time_reference <= ? AND login_time != \'0000-00-00 00:00:00\' ', array($this->employee->id, $current_start_time, $current_end_time) )->first();

        $break_date_time = date('Y-m-d H:i:s');
        $break_REF_time = date('Y-m-d H:i:s', strtotime('11:00:00'));
        $break_REF_time2 = date('Y-m-d H:i:s', strtotime('13:00:00'));

        if( $break_date_time < $break_REF_time ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'You are not yet allowed to take your break.';
            $attendance->break_time = date('0000-00-00 00:00:00');
        }

        else if( $break_date_time > $break_REF_time2 ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'You are not allowed to take your break.';
            $attendance->break_time = date('0000-00-00 00:00:00');
        }

        else {
            $post = new Post();
            $post->body = 'is on break';
            $post->employee_id = Auth::user()->id;
            $post->created_at = $break_date_time;
            $post->save();
            $attendance->break_time = $break_date_time; 
            $this->params['msg'] = 'You are currently on a break.';
        }

        $attendance->save();
        return Response::json($this->params);
    }

    public function attendance_stopbreak() {
        $day = strtolower( date('l') );
        $current_start_time = date('Y-m-d 00:00:00');
        $current_end_time = date('Y-m-d 23:59:59');
        $attendance = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND login_time_reference <= ? AND login_time != \'0000-00-00 00:00:00\' ', array($this->employee->id, $current_start_time, $current_end_time) )->first();
        
        $stopbreak_time = time();
        $break_time = strtotime($attendance->break_time);
        $stopbreak_date_time = date('Y-m-d H:i:s');

        $post = new Post();
        $post->body = 'ended break';
        $post->employee_id = Auth::user()->id;
        $post->created_at = $stopbreak_date_time;
        $post->save();

        // Logged record
        $attendance->break = $stopbreak_time - $break_time;
        $attendance->stopbreak_time = $stopbreak_date_time;
        $attendance->save();
        $this->params['msg'] = 'Time to go back to work!';
        return Response::json($this->params);
    }
    //Fin

    public function attendance_logout()
    {
        $day = strtolower( date('l') );

        // Check if attendance record and if employee is already logged in
        $current_start_time = date('Y-m-d 00:00:00');
        $current_end_time = date('Y-m-d 23:59:59');
        $attendance = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND login_time_reference <= ? AND login_time != \'0000-00-00 00:00:00\' ', array($this->employee->id, $current_start_time, $current_end_time) )->first();
        if( !$attendance ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'Sorry but it seems that you forgot to login. Please log in first.';
            return Response::json($this->params);
        }

        // Check if already logged out
        if( $attendance->logout_time != '0000-00-00 00:00:00' ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'Sorry but it seems that you already logged out at '.$attendance->logout_time;
            return Response::json($this->params);
        }

        $logout_time = time();
        $logout_date_time = date('Y-m-d H:i:s');

        // reference the stored attendance record time references
        $logout_REF_date_time = $attendance->logout_time_reference;
        $logout_REF_time = strtotime( $logout_REF_date_time );
        
        $current_start_time = date('Y-m-d 00:00:00');
        $current_end_time = date('Y-m-d 23:59:59');

        $stopbreaktime = $attendance->stopbreak_time;
        $startbreaktime = $attendance->break_time;
        if($stopbreaktime == '0000-00-00 00:00:00' && $startbreaktime != '0000-00-00 00:00:00' ){
            $attendance->stopbreak_time = $logout_date_time;
            $attendance->break = $logout_time - (strtotime($attendance->break_time));
        }
        // Check if he is undertime
        if( $logout_time < $logout_REF_time ) {
            $late_in_minutes = ($logout_REF_time - $logout_time) / 60;
            $this->params['msg'] = 'You have successfully logged out but you are undertime for '.(round($late_in_minutes)).' minutes.';
            $this->params['status'] ='UNDERTIME';
            $undertime = $logout_REF_time - $logout_time;
            $attendance->undertime = $undertime;
            $attendance->status = $attendance->status.'|UNDERTIME';

        } elseif( $logout_time > $logout_REF_time ) {
            $overtime_in_minutes = ($logout_time - $logout_REF_time) / 60;
            $this->params['msg'] = 'You have successfully logged out and overtime for '.$overtime_in_minutes.' mins. You work really hard.';
            $this->params['status'] ='OVERTIME';
            $overtime = $logout_time - $logout_REF_time;
            $attendance->overtime = $overtime;
            $attendance->status = $attendance->status.'|OVERTIME';

        }else {
            $this->params['msg'] = 'You have successfully logged out. ';
        }

        $post = new Post();
        $post->body = 'logged out';
        $post->employee_id = Auth::user()->id;
        $post->created_at = $logout_date_time;
        $post->save();

        // Logged record
        $attendance->logout_time = $logout_date_time;
        $attendance->save();

        return Response::json($this->params);
    }

    public function show( $what = null ) 
    {
     

        $week_start = date('Y-m-d 00:00:00',$this->week_date(date("W"), 0 ) );
        $week_end = date('Y-m-d 00:00:00',$this->week_date(date("W"), 6 ) );

        $what ? $what = $what: $what = 'home';


        if( !in_array($what, $this->employee_mgnt) && $what != 'home' ) {
            // TODO: redirect not found
            // return 'not fou2nd1';
              return Redirect::to('/login');
        }

        if( $what == 'attendance' ) {
            // Get weekly attendance
            $this->params['weekly_attendance'] = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND login_time_reference <= ?', array( $this->employee->id, $week_start, $week_end) )->get();
            $this->params['menu_action'] = 'today';
        }

        if( $what == 'attendance_report' ) {
            // Get all attendance
            if( isset($_GET['start_date']) && $_GET['start_date'] && isset($_GET['end_date']) && $_GET['end_date'] ) {
                $from = date( $_GET['start_date']);
                $to = date('Y-m-d', strtotime($_GET['end_date']) + 86400);
                if ($from > $to) {
                    Session::flash('flash_error', 'Start Date must be before End Date.');
                }
                if ($from > $to) {
                    Session::flash('flash_error', 'Start Date must be before End Date.');
                }
                else {
                    Session::forget('flash_error');
                }
                $this->params['weekly_attendance'] = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND logout_time < ?', array($this->employee->id, $from, $to) )->get();

            }
            else {
                $this->params['weekly_attendance'] = Attendance::whereRaw('employee_id = ?', array( $this->employee->id) )->get();
            }
            if( count($this->params['weekly_attendance']) == 0) {
                return redirect('employee/attendance')->with('flash_error', 'No time in record yet.');
            }
            $this->params['menu_action'] = 'today';
            if( count($this->params['weekly_attendance']) == 0) {
                return Redirect::to('/');
            }
        }

        
        /* 

        Weekly Attendance 

        */
        $weekly_attendance = array(  'Mon'   => (object) array(
                                      'day' => 'monday',
                                      ),
                            'Tue'   => (object) array(
                                      'day' => 'tuesday',
                                      ),
                            'Wed'   => (object) array(
                                      'day' => 'wednesday',
                                      ),
                            'Thu'   => (object) array(
                                      'day' => 'thursday',
                                      ),
                            'Fri'   => (object) array(
                                      'day' => 'friday',
                                      ),

                            );

        $attendances = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND login_time_reference <= ?', array( $this->employee->id, $week_start, $week_end) )->get();

        $total_lates = 0;
        $total_early = 0;
        $total_overtime = 0;
        $total_undertime = 0;


        foreach ($weekly_attendance as $day => $value) {
            

            foreach ($attendances as $attendance) {
                
                

                if( $value->day == $attendance->day){

                    $weekly_attendance[$day] = $attendance;
                    $total_lates += $attendance->lates;
                    $total_early += $attendance->early;
                    $total_overtime += $attendance->overtime;
                    $total_undertime += $attendance->undertime;

                    break;
                
                }else{

                    $weekly_attendance[$day] = null;
                }                
            }
        }
        
    
        
        $weekly_report['total_lates'] = $total_lates;
        $weekly_report['total_early'] = $total_early;
        $weekly_report['total_overtime'] = $total_overtime;
        $weekly_report['total_undertime'] = $total_undertime;

        $this->params['weekly_report'] = $weekly_report;
        $this->params['weekly_attendance'] = $weekly_attendance;
        $this->params['attendance_reference'] = $this->employee->attendance_reference->where('disabled', '=', 0);
        $this->params['emp'] = $this->employee;
        $this->params['what'] = $what;
        $this->params['departments'] = Department::all();
        return view('employees.show'. ($what != 'home' ? '-'.$what:''), $this->params);
    }



    function week_date($week_num, $day, $year = null ) {
        $year = $year ? $year : date('Y');
        $timestamp    = strtotime( $year . '-W' . $week_num . '-' . $day);
        return $timestamp;
    }



    private function _update_profile_image( $inputs = null, $employee = null )
    {
        // Check if email address changed. If so, add rule to check if email already exist.
        $file = Request::file('profile_photo');
        if ( !Request::hasFile('profile_photo') || !$file->isValid() ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'Photo is not valid!';
            Session::flash('flash_error', 'File is not valid!');
            return $this->params;
        }

        // Check if photo name in the database exist. If so, then just use the that photo name
        if( $employee->photo ) {
            $photo = explode('.', $employee->photo );
            $image_name = $photo[0];
            $extension = $photo[1];
        } else {
            $image_name = time() . "_" . md5( $file->getClientOriginalName() );
            $extension = $file->getClientOriginalExtension();
        }
        
        // Check if valid file extension
        if( !in_array( strtolower($extension), array('jpg', 'jpg', 'png') ) ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'File is not valid!';
            Session::flash('flash_error', 'File is not valid!');
            return $this->params;
        }

        // TODO: Check file size

        $image_name_50 = $image_name.'_50.'.$extension;
        $image_name_100 = $image_name.'_100.'.$extension;
        $image_name_200 = $image_name.'_200.'.$extension;

        $original_image_name =  $image_name;
        $original_image = $image_name.'.'.$extension;
        $target_path = 'images/employees/profile_photo';

        $file->move($target_path, $original_image);

        // Update photo field in the database
        $employee->photo = $original_image;
        $employee->save();

        // Create thumbnail sizess
        $image_new_name = $original_image_name.'_50.'.$extension;
        File::copy($target_path .'/'. $original_image, $target_path .'/'. $image_new_name);
        $image = Image::make(sprintf($target_path.'/%s', $image_new_name))->resize(50, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save();

        $image_new_name = $original_image_name.'_100.'.$extension;
        File::copy($target_path .'/'. $original_image, $target_path .'/'. $image_new_name);
        $image = Image::make(sprintf($target_path.'/%s', $image_new_name))->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save();

        $image_new_name = $original_image_name.'_200.'.$extension;
        File::copy($target_path .'/'. $original_image, $target_path .'/'. $image_new_name);
        $image = Image::make(sprintf($target_path.'/%s', $image_new_name))->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save();


        Session::flash('flash_notice', 'Photo has been updated!');
        //$this->params['msg'] = 'Photo has been updated!';
        return $this->params;
    }

    public function update( $id = null, $what = null ) 
    {
        if( !in_array($what, $this->employee_mgnt) && $what != 'home' ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'Unable to update information at this time. Please try again later.';
            return Response::json($this->params);
        }

        // Check if employee exist
        $emp = Employee::find( $id );
        if( !$emp ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'Unable to update information at this time \n or employee does not exist.';
            return Response::json($this->params);
        }

        $this->params['emp'] = $emp;
        $this->params['what'] = $what;
        $this->params['departments'] = Department::all();

        $func = "_update_".$what;

        if( $what == 'profile_image' ) {
            $this->$func( Input::all(), $emp );
            // return view('employees.show-profile_image', $this->params);
            return redirect('/employee/profile_image');
        }

        return Response::json( $this->$func( Input::all(), $emp ) );
    }

    public function leaves( $id = null, $what = null)
    {

        $what ? $what = $what: $what = 'home';


        if( !in_array($what, $this->employee_mgnt) && $what != 'home' ) {
            // TODO: redirect not found
            // return 'not found1';
            return Redirect::to('/login');
        }

        $week_start = date('Y-m-d ',$this->week_date(date("W"), 0 ) );
        $week_end   = date('Y-m-d ',$this->week_date(date("W"), 6 ) );

            if( isset($_GET['start_date']) && $_GET['start_date'] ){

                $week_start = date( $_GET['start_date']);

            }
            
            if( isset($_GET['end_date']) && $_GET['end_date'] ){

                $week_end = date( $_GET['end_date']);
                
            }

            if( $week_start > $week_end) {

               Session::flash('flash_message', 'error');
            }



        $employee_id = Auth::user()->id;

        $rules  = array(
            'start_date'        => 'required|date',
            'end_date'          => 'required|date',
            'reasons'           => 'required|min:50|max:2000',
        );

        $validator = Validator::make( Input::all(), $rules );

        if ( $validator->fails() ) {
            $messages = $validator->messages()->getMessages();
            $this->params['error'] = true;
            foreach ($messages as $field_name => $message) $this->params['msg'] .= '<br/>'.$message[0];
            Session::flash('flash_message', 'error');
            //return Response::json($this->params);
        }else{

        $leaves = new Leaves;
        $leaves->employee_id                = $employee_id;
        $leaves->start_date                 = Input::get('start_date');
        $leaves->end_date                   = Input::get('end_date');
        $leaves->reason_of_leave            = Input::get('reasons');
        $leaves->note                       = Input::get('note_for_absent');
        $leaves->no_of_days                 = Input::get('no_of_days');

        $leaves->save();

        Session::flash('flash_message', 'success');
        }

    $this->params['week_start']             = $week_start;
    $this->params['week_end']               = $week_end;
    $this->params['error'] = false;
    $this->params['departments'] = Department::all();
    $this->params['emp'] = $this->employee;
    $this->params['what'] = $what;
    //return view('employees.show'. ($what != 'home' ? '-'.$what:''), $this->params);
    return view('employees.show-leave_form',$this->params);
        
    }
}