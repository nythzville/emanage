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

class AdminLeavesController extends Controller {

	private $leave_mgnt = array(
                    
                    'leave_details',
                    'leave_applications',
                    
                    
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

        // authentication failure! lets go back to the login page
        if ( !Auth::check() ) {
            return Redirect::to('login')
                ->with('flash_error', 'Your session has expired please login again.')->send();
        }

        // Check if has admin rights
        if( !in_array( Auth::user()->account_type, Config::get('app.admins') ) ) {
            return Redirect::to('user')
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

        $this->params['employee'] = Auth::user();
    }

	public function index( $what = null ){

        if( isset($_GET['employee_id']) && $_GET['employee_id'] ) {
            $id = $_GET['employee_id'];
            $this->params['leaves'] = Leaves::where("employee_id" , "=" ,$id )
            ->orderBy('created_at', 'desc')
            ->get();
            
        }else{
            
            $this->params['leaves'] = Leaves::where("leave_status","!=", 'INACTIVE')->get();  
            
        }
        
        $is_all = true;

        if( isset($_GET['employee_id'])){
            $is_all = false;

            $emp = Employee::find( $id );
            if( !$emp ) {
                // TODO: redirect not found
                // return 'not found2';
                return Redirect::back();
            }
            
            $this->params['emp'] = $emp;
        }

        $this->params['employees'] = Employee::all();
        $this->params['is_all'] = $is_all;
        $this->params['what'] = $what;
        $this->params['menu_action'] = 'show';

        return view('admin.employees.leaves.index', $this->params);
	}

    public function show( $id = null , $what = null ){

        $leave = leaves::find( $id );
        if( !$leave ) {
            // TODO: redirect not found
            echo 'Record not found!';
            exit();
        }

        $what ? $what = $what: $what = 'home';

        if( !in_array($what, $this->leave_mgnt) && $what != 'home' ) {
            // TODO: redirect not found
            // return 'not found3333';
            return Redirect::back();
        }
        
        $emp = $leave->employee;
        $this->params['emp']= $emp;
        $this->params['emp_id']= $leave->employee_id;
        $this->params['leave']= $leave;
        $this->params['what'] = $what;
        return view('admin.employees.leaves.show'. ($what != 'home' ? '-'.$what:''), $this->params);  

    }

	public function create() {

        $this->params['menu_action'] = 'create';
        $this->params['employees'] = Employee::all();
        return view('admin.employees.leaves.create', $this->params);
    }

    public function store( $id = null, $what = null)
    {

        $what ? $what = $what: $what = 'home';

        if( !in_array($what, $this->leave_mgnt) && $what != 'home' ) {
            // TODO: redirect not found
            // return 'not found3';
            return Redirect::back();
        }
       
        $rules  = array(
            'start_date'        => 'required|date|after:today',
            'end_date'          => 'required|date|after:start_date',
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
        $leaves->employee_id                = Input::get('firstname');
        $leaves->start_date                 = Input::get('start_date');
        $leaves->end_date                   = Input::get('end_date');
        $leaves->reason_of_leave            = Input::get('reasons');
        $leaves->note                       = Input::get('note_for_absent');
        $leaves->no_of_days                 = Input::get('no_of_days');
        $leaves->leave_status               = "APPROVED";

        $leaves->save();

        Session::flash('flash_message', 'success');
        }

    $this->params['what'] = $what;
    $this->params['leaves'] = Leaves::all();
    $this->params['employees'] = Employee::all();
    return $this->params;
    //return view('admin.employees.leaves.create',$this->params);
        
    }

    public function update( $id = null , $what = null ){

        $leaves = leaves::find( $id );
        if( !$leaves ) {
            // TODO: redirect not found
            echo 'Record not found!2';
            exit();
        }

        if( !in_array($what, $this->leave_mgnt) && $what != 'home' ) {
             // TODO: redirect not found 
            // return 'not found4';
            return Redirect::back();
        }

        $rules  = array(
            'start_date'        => 'required|date|after:today',
            'end_date'          => 'required|date|after:start_date',
            'reasons'           => 'required|min:50|max:2000',
        );

        $validator = Validator::make(  Input::all(), $rules );

        if ( $validator->fails() ) {
            $messages = $validator->messages()->getMessages();
            $this->params['error'] = true;
            foreach ($messages as $field_name => $message) $this->params['msg'] .= '<br/>'.$message[0];
            Session::flash('flash_message', 'error');
            //return Response::json($this->params);
        }else{

        $leaves->start_date                 = Input::get('start_date');
        $leaves->end_date                   = Input::get('end_date');
        $leaves->reason_of_leave            = Input::get('reasons');
        $leaves->note                       = Input::get('note_for_absent');
        $leaves->no_of_days                 = Input::get('no_of_days');
        $leaves->leave_status               = Input::get('leave_status');

        $leaves->save();

        $this->params['error'] = false;
        $this->params['msg'] = 'Employee leave details has been successfully updated!';
        }

    $emp = $leaves->employee;
    $this->params['emp']= $emp;
    $this->params['leave']= $leaves;
    $this->params['what'] = $what;
    return $this->params;

    }


    function week_date($week_num, $day, $year = null ) {
        $year = $year ? $year : date('Y');
        $timestamp    = strtotime( $year . '-W' . $week_num . '-' . $day);
        return $timestamp;
    }

}