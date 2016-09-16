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
use Session;

use App\Employee;
use App\Leaves;
use App\Department;
use App\Attendance;

class AdminAttendanceController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | AUTHOR: ryandejandobinas@gmail.com
    | EMPLOYEE MANAGEMENT CONTROLLER
    |--------------------------------------------------------------------------
    |
    */


    public function __construct()
    {
        $this->params = array(
            'error' => false,
            'redirect' => false,
            'redirect_to' => '/',
            'msg' => '',
            'mainmenu' => 'attendance',
            'menu_action' => 'index'
        );

        // authentication failure! lets go back to the login page
        if ( !Auth::check() ) {
            return Redirect::to('login')
                ->with('flash_error', 'Your session has expired please login again.')->send();
        }

        // Check if has admin rights
        if( !in_array( Auth::user()->account_type, Config::get('app.admins') ) ) {
            return Redirect::to('login')
                ->with('flash_error', 'Your are not allowed to access the page.')->send();
        }

        $this->params['employee'] = Auth::user();

        $this->params['week_days'] = array(
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
        );
    }

    public function index()
    {
        $this->params['menu_action'] = 'today';

        $from   = date('Y-m-d 00:00:00', time());
        $to     = date('Y-m-d 23:59:59', time());

        $emp = Employee::all();
        if( !$emp ) {
            // TODO: redirect not found
            echo 'No employee found!';
            exit();
        }

        $is_weekly = true;

        if( isset($_GET['start_date']) || isset($_GET['end_date'])){
            $is_weekly = false;

            if( isset($_GET['start_date']) && $_GET['start_date'] ) {
                $from = date( $_GET['start_date']);
            }
            

            if( isset($_GET['end_date']) && $_GET['end_date'] ) {
                $to = date( $_GET['end_date']);
            }
     
            if( $from > $to){
               Session::flash('flash_error', 'Invalid date Inputs ');
            }
        }

        $this->params['on_leave'] = 
            Leaves::where('leave_status', 'APPROVED')
            ->take(12)
            ->get();

        $this->params['is_weekly']        = $is_weekly;
        $this->params['from']             = $from;
        $this->params['to']               = $to;
        $this->params['emp']              = $emp;
        $this->params['attendance'] = Attendance::whereRaw('login_time_reference >= ? AND login_time_reference < ?', array($from, $to) )->get();
        return view('admin.employees.attendance.index', $this->params);
    }

    public function show( $id = null )
    {
        // Check if employee exist,
        $emp = Employee::find( $id );
        if( !$emp ) {
            // TODO: redirect not found
            echo 'employee not found!';
            exit();
        }
        
        $is_weekly = true;

        if( isset($_GET['start_date']) || isset($_GET['end_date'])){
            $is_weekly = false;
        }
       
        
        $week_start = date('Y-m-d ',$this->week_date(date("W"), 0 ) );
        $week_end   = date('Y-m-d ',$this->week_date(date("W"), 6 ) );

        if( isset($_GET['start_date']) && $_GET['start_date'] ) {
            $week_start = date( $_GET['start_date']);

        }
        

        if( isset($_GET['end_date']) && $_GET['end_date'] ) {
            $week_end = date( $_GET['end_date']);
            
        }
 
        if( $week_start > $week_end){
           return redirect('admin/employee/attendance/' .$emp->id. '/show_attendance')->with('flash_error', 'Invalid Date Input.');
        }
       

        $this->params['attendance_reference']   = $emp->attendance_reference->where('disabled', '=', 0);
        $this->params['is_weekly']              = $is_weekly;
        $this->params['week_start']             = $week_start;
        $this->params['week_end']               = $week_end;
        $this->params['emp']                    = $emp;
        $this->params['departments']            = Department::all();
        $this->params['weekly_attendance']      = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND login_time_reference <= ?', array( $emp->id, $week_start, $week_end) )->get();

        return view('admin.employees.attendance.show-attendance', $this->params);
    }

    function week_date($week_num, $day, $year = null ) {
        $year = $year ? $year : date('Y');
        $timestamp    = strtotime( $year . '-W' . $week_num . '-' . $day);
        return $timestamp;
    }
}