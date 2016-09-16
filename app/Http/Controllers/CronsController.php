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

use App\Employee;
use App\Department;
use App\Attendance;
use App\AttendanceReference;

class CronsController extends Controller {

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
        );
    }

    public function attendance_creation()
    {
        // Get current day
        $day = strtolower(date('l'));

        $current_start_time = date('Y-m-d 00:00:00');
        $current_end_time = date('Y-m-d 23:59:59');

        // Get all employees
        $employees = Employee::all();

        if( $employees ) {
            foreach ( $employees as $employee ) {
                // Get employee attendance reference today
                $attendance_ref = AttendanceReference::whereRaw('employee_id = ? AND day = ?', array($employee->id, $day))->first();
                if( $attendance_ref ) {
                    // Check if attendance already exists
                    $attendance = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND login_time_reference <= ?', array($employee->id, $current_start_time, $current_end_time) )->first();
                    if( !$attendance ) {
                        // If not exist, Create new attendance
                        $today = date('Y-m-d');
                        $attendance = new Attendance;
                        $attendance->employee_id = $employee->id;
                        $attendance->login_time = '0000-00-00 00:00:00';
                        $attendance->logout_time = '0000-00-00 00:00:00';
                        $attendance->login_time_reference = $today.' '.$attendance_ref->login_time_reference.'';
                        $attendance->logout_time_reference = $today.' '.$attendance_ref->logout_time_reference;
                        $attendance->day = $attendance_ref->day;
                        $attendance->status = 'ABSENT';
                        $attendance->save();
                    }

                }
            }
        }
    }


    public function leave_status_reject()
    {
        $day  = date('Y-m-d');
        $leaves = Leaves::whereRaw('start_date = ? AND leave_status =?', array($day, 'PENDING'))->get();
        if($leaves->count() >= 1 ){
            foreach ($leaves as $leave){
            $leave->leave_status = "REJECTED";
            $leave->save();
            }
            
        }

    }

    public function leave_status_incative()
    {
        $day  = date('Y-m-d');
        $leaves = Leaves::where("end_date", "=" , $day)->get();
        if($leaves->count() >= 1 ){
            foreach ($leaves as $leave){
            $leave->leave_status = "INACTIVE";
            $leave->save();
            }
        }
    }
}