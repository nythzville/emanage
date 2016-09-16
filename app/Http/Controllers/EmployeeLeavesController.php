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

use App\Leaves;
use App\Employee;
use App\Department;
use App\AttendanceReference;
use App\Attendance;

// use App\Http\Requests;
// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class EmployeeLeavesController extends Controller {

    private $leave_mgnt = array(
                    
                    'create_leave',
                    'leave_application'                   
                );

    public function __construct()
    {
        $this->params = array(
            'error' => false,
            'redirect' => false,
            'redirect_to' => '/',
            'msg' => '',
            'mainmenu' => 'leaves',
            'menu_action' => 'index'
        );

        // Authentication failure! lets go back to the login page
        if ( !Auth::check() ) {

            return Redirect::to('login')
                ->with('flash_error', 'Your session has expired please login again.')->send();
        }

        // Check if has admin rights
        if( in_array( Auth::user()->account_type, Config::get('app.admins') ) ) {
            return Redirect::to('dashboard')
                ->with('flash_error', 'Your are not allowed to access the page.')->send();
        }

        $this->params['week_days'] = array(
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
        );

        $this->employee = $this->params['employee'] = Auth::user();
    }

    public function show( $what = null ) 
    {
        $what ? $what = $what: $what = 'home';

        if( !in_array($what, $this->leave_mgnt) && $what != 'home' ) {
            // TODO: redirect not found
            // return 'not found3';
            return Redirect::back();
        }

        $employee_id = Auth::user()->id;
        $this->params['emp'] = $this->employee;
        $this->params['menu_action'] = 'create';
        $this->params['what'] = $what;
        $this->params['employees'] = Employee::all();
        $this->params['leaves'] = Leaves::where("employee_id" , "=" ,$employee_id )->get();

        
        return view('employees.leaves.show'. ($what != 'home' ? '-'.$what:''), $this->params);

    }


	public function store( $id = null, $what = null )
    {
        $what ? $what = $what: $what = 'home';

        if( !in_array($what, $this->leave_mgnt) && $what != 'home' ) {
            // TODO: redirect not found
            // return 'not found3';
            return Redirect::back();
        }
       
        $employee_id = Auth::user()->id;

        $rules  = array(
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after:start_date',
            'reasons'           => 'required|min:50|max:2000',
        );

        $validator = Validator::make( Input::all(), $rules );

        if ( $validator->fails() ) {
            $messages = $validator->messages()->getMessages();
            $this->params['error'] = true;
            foreach ($messages as $field_name => $message) $this->params['msg'] .= '<br/>'.$message[0];
            return Response::json($this->params);
        }else{

        $leaves = new Leaves;
        $leaves->employee_id                = $employee_id;
        $leaves->start_date                 = Input::get('start_date');
        $leaves->end_date                   = Input::get('end_date');
        $leaves->reason_of_leave            = Input::get('reasons');
        $leaves->note                       = Input::get('note_for_absent');
        $leaves->no_of_days                 = Input::get('no_of_days');

        $leaves->save();

        $this->params['error'] = false;
        $this->params['msg'] = 'Form has been successfully submitted!';
        }
    
    $this->params['departments'] = Department::all();
    $this->params['emp'] = $this->employee;
    $this->params['what'] = $what;
    $this->params['leaves'] = Leaves::where("employee_id" , "=" ,$employee_id )->get();
    return $this->params;  
    }

    function week_date($week_num, $day, $year = null ) {
        $year = $year ? $year : date('Y');
        $timestamp    = strtotime( $year . '-W' . $week_num . '-' . $day);
        return $timestamp;
    }
}