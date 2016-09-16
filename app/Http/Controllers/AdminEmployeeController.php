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
use Storage;
use Session;

use App\Attendance;
use App\Leaves;
use App\Employee;
use App\MyEmployee;
use App\Department;
use App\AttendanceReference;

class AdminEmployeeController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | AUTHOR: ryandejandobinas@gmail.com
    | EMPLOYEE MANAGEMENT CONTROLLER
    |--------------------------------------------------------------------------
    |
    */

    private $employee_mgnt = array(

                    'personal_information',
                    'account_details',
                    'work_details',
                    'profile_image',
                    'attendance_reference',
                    'attendance_report',
                    'attendance',
                    'leave_list',
                    
                );

    public function __construct()
    {
        $this->params = array(
            'error' => false,
            'redirect' => false,
            'redirect_to' => '/',
            'msg' => '',
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

        $this->params['current_user'] = Auth::user();
    }

    public function index()
    {
        $this->params['action'] = 'today';
        $this->params['employees'] = Employee::all();
        $this->params['departments'] = Department::all();
        $this->params['what'] = 'employeesList';
        

        // Get latest employee
        $this->params['latest_employees'] = 
            Employee::where('status', 'ACTIVE')
               ->orderBy('start_date', 'desc')
               ->take(12)
               ->get();

        return view('admin.employee.list', $this->params);
    }

    public function create() 
    {
        $this->params['action'] = 'create';
        $this->params['what'] = 'create_employee';
        $this->params['departments'] = Department::all();
        return view('admin.employee.form', $this->params);
    }

    public function store() 
    {
        // Define employee fields rules
        $rules = array(
            'email'             => 'required|email|unique:employees',
            'account_type'      => 'required|min:2|max:20',
            'password'          => 'required|min:6',
            'confirm_password'  => 'required|same:password' ,
            'identification'    => 'required|min:5|max:15|unique:employees',

            'firstname'         => 'required|min:2|max:30',
            'lastname'          => 'required|min:2|max:30',
            'birthdate'         => 'required|date|date_format:"m/d/Y"|before:"now"',
            'gender'            => 'required|min:2|max:8',
            'mobile_no'         => 'min:5|max:50',
            'phone_no'          => 'min:5|max:50',
            'address'           => 'required|min:10|max:100',

            'start_date'        => 'required|date|date_format:"m/d/Y"',
            'employment_status' => 'required|min:2|max:30',
            'job_title'         => 'required|min:2|max:100',
            'department_id'     => 'required|integer',
            'employment_type'   => 'required|min:2|max:30',
            'job_description'   => 'required|min:50|max:2000',
        );

        // Validate data
        $validator = Validator::make( Input::all(), $rules );
        if ( $validator->fails() ) {
            $messages = $validator->messages()->getMessages();
            $this->params['error'] = true;
            foreach ($messages as $field_name => $message) {
                $this->params['msg'] .= '<br/>'.$message[0];
            }
            return Response::json($this->params);
        }

        // Create new employee
        $employee = new Employee;
        $employee->email                    = Input::get('email');
        $employee->account_type             = in_array( Input::get('account_type'), array('normal','hr', 'admin', 'owner') ) ? Input::get('account_type') : 'normal';
        $employee->identification           = Input::get('identification');
        $employee->password                 = Crypt::encrypt ( Input::get('password') );
        //$encrypted = Crypt::encrypt('secret');
        $employee->firstname                = Input::get('firstname');
        $employee->lastname                 = Input::get('lastname');
        $employee->birthdate                = date('Y-m-d', strtotime( Input::get('birthdate') ) );
        $employee->gender                   = Input::get('gender');
        $employee->mobile_no                = Input::get('mobile_no');
        $employee->phone_no                 = Input::get('phone_no');
        $employee->address                  = Input::get('address');

        $employee->start_date               = date('Y-m-d', strtotime( Input::get('start_date') ) );
        $employee->employment_status        = Input::get('employment_status');
        $employee->job_title                = Input::get('job_title');
        $employee->department_id            = Input::get('department_id');
        $employee->employment_type          = Input::get('employment_type');
        $employee->job_description          = Input::get('job_description');
        $employee->status                   = "ACTIVE";
        $employee->photo                    = "images/user.png";

        $employee->uid                      = sha1( uniqid().Input::get('firstname') );
        $employee->save();

        // Create attendance reference
        foreach ( $this->params['week_days'] as $day_key => $day ) {
            $day = strtolower($day);

            $attendance_ref = new AttendanceReference;

            // Just make saturday and sunday DISABLED by default
            if ( $day == 'sunday' || $day == 'saturday' ) $attendance_ref->disabled = 1;
            $attendance_ref->employee_id = $employee->id;
            $attendance_ref->login_time_reference = '09:00:00';
            $attendance_ref->logout_time_reference = '17:00:00';
            $attendance_ref->day = strtolower($day);
            $attendance_ref->save();
        }

        $this->params['error'] = false;
        //$this->params['redirect'] = true;
        //$this->params['redirect_to'] = 'admin/employee/'.$employee->id.'/personal_information';
        $this->params['employee'] = $employee;        
        $this->params['msg'] = 'Successfully created new Employee!';
        
        //return Response::json($this->params);

        return redirect('admin/employee/' .$employee->id. '/edit')->with($this->params);
    }


    /* Employee Edit Fuction */

    public function edit( $id ){
        
        if( !$id ) {
            // TODO: redirect not found
            return Redirect::to('/');
        }
        
        // Check if employee exist
        $employee = MyEmployee::find( $id );

        $this->params['employee']               = $employee;
        $this->params['what']                   = 'edit_employee';
        $this->params['action']                 = 'update';
        $this->params['attendance_reference']   = $employee->attendance_reference;
        $this->params['departments']            = Department::all();

        //dd($employee);
        return view('admin.employee.edit-form', $this->params);
    }


    public function show( $id ) 
    {
        // if( !$id ) {
        //     // TODO: redirect not found
        //     return Redirect::to('/');
        // }

        // // Check if employee exist
        // $emp = Employee::find( $id );
        // if( !$emp ) {
        //     // TODO: redirect not found
        //     return Redirect::to('/');
        // }



        // $what ? $what = $what: $what = 'home';

        // if( !in_array($what, $this->employee_mgnt) && $what != 'home' ) {
        //     // TODO: redirect not found
        //     // return 'not found3';
        //     return Redirect::to('/');
        // }

        // $this->params['emp']                    = $emp;
        // $this->params['what']                   = $what;
        // $this->params['attendance_reference']   = $emp->attendance_reference;
        // $this->params['departments']            = Department::all();
        // $this->params['leaves'] = Leaves::where("employee_id" , "=" ,$id )->get();

        // // if($what == 'edit'){
        // //     $this->params['action'] = 'edit';
        // //     return view('admin.employee.form', $this->params);
        // // }

        // if ( $what == 'attendance') {

        //     $is_weekly = true;

        //     if( isset($_GET['start_date']) || isset($_GET['end_date'])) {

        //         $is_weekly = false;
        //     }

        //     $week_start = date('Y-m-d ',$this->week_date(date("W"), 0 ) );
        //     $week_end   = date('Y-m-d ',$this->week_date(date("W"), 6 ) );

        //     if( isset($_GET['start_date']) && $_GET['start_date'] ){

        //         $week_start = date( $_GET['start_date']);

        //     }
            
        //     if( isset($_GET['end_date']) && $_GET['end_date'] ){

        //         $week_end = date( $_GET['end_date']);
                
        //     }

        //     if( $week_start > $week_end) {

        //        return redirect('admin/employee/' .$emp->id. '/attendance')->with('flash_error', 'Invalid Date Input.');
        //     }

        //     $this->params['is_weekly']              = $is_weekly;
        //     $this->params['week_start']             = $week_start;
        //     $this->params['week_end']               = $week_end;
        //     $this->params['weekly_attendance']      = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND login_time_reference <= ?', array( $emp->id, $week_start, $week_end) )->get();
        // }

        // if( $what == 'attendance_report' ) {
        //     // Get all attendance
        //     if( isset($_GET['start_date']) && $_GET['start_date'] && isset($_GET['end_date']) && $_GET['end_date'] ) {
        //         $from = date( $_GET['start_date']);
        //         $to = date('Y-m-d', strtotime($_GET['end_date']) + 86400);
        //         if($from > $to){
        //             Session::flash('flash_error', 'Start Date must be before End Date.');
        //         }
        //         if($from > $to){
        //             Session::flash('flash_error', 'Start Date must be before End Date.');
        //         }
        //         else{
        //             Session::forget('flash_error');
        //         }
        //         // $this->params['weekly_attendance'] = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND logout_time < ?', array($this->employee->id, $from, $to) )->orderBy('login_time', 'desc')->get();
        //         $this->params['weekly_attendance'] = Attendance::whereRaw('employee_id = ? AND login_time_reference >= ? AND logout_time < ?', array($emp->id, $from, $to) )->get();
        //     }
        //     else {
        //         $this->params['weekly_attendance'] = Attendance::whereRaw('employee_id = ?', array( $emp->id) )->get();
        //     }
        //     if( count($this->params['weekly_attendance']) == 0) {
        //         return redirect('admin/employee/' .$emp->id. '/attendance')->with('flash_error', 'No time in record yet.');
        //     }
        // }

        
        // return view('admin.employees.show'. ($what != 'home' ? '-'.$what:''), $this->params);
    }


    /* UPDATE EMPLOYEE */

    public function update( $id ) 
    {
        $what =  Input::get('what');

        if( !in_array($what, $this->employee_mgnt) && $what != 'home' ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'Unable to update information at this time. Please try again later.';
            return Response::json($this->params);
        }

        // Check if employee exist
        $emp = Employee::find( $id );
        if( !$emp ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'Unable to update information at this time /\n or employee does not exist.';
            return Response::json($this->params);
        }

        $this->params['emp'] = $emp;
        $this->params['what'] = $what;
        $this->params['departments'] = Department::all();

        $func = "_update_".$what;

        if( $what == 'profile_image' ) {

            $this->$func( Input::all(), $emp );

            return redirect('admin/employee/' .$emp->id. '/profile_image');
            // return view('admin.employees.show'. ($what != 'home' ? '-'.$what:''), $this->params);

        }

        return Response::json( $this->$func( Input::all(), $emp ) );
    }




    private function _update_attendance_reference( $inputs = null, $employee = null )
    {

        $this->params['inputs'] = $inputs;

        return $this->params;
        // $day_of = strtolower(Input::get('day_of'));
        // // Check if day is valid
        // if( !in_array( ucfirst($day_of), $this->params['week_days']) ) {
        //     $this->params['msg'] = 'An error encountered. Please try again later.';
        //     $this->params['error'] = true;
        //     return $this->params;
        // }

        // // Check if disabled. If so, just update the 'disabled' field to true = 1
        // if( Input::get('disabled') ) {
        //     $this->params['msg'] = 'Attendance reference has been disabled.';
        //     $attendance_reference = AttendanceReference::whereRaw('employee_id = ? AND day = ?', array( $employee->id , $day_of) )->first();

        //     if( $attendance_reference ) {
        //         $attendance_reference->disabled = 1;
        //     } else {
        //         $attendance_reference = new AttendanceReference;
        //         $attendance_reference->employee_id = $employee->id;
        //         $attendance_reference->login_time_reference = '09:00:00';
        //         $attendance_reference->logout_time_reference = '17:00:00';
        //         $attendance_reference->day = $day_of;
        //         $attendance_reference->disabled = 1;
        //     }

        //     $attendance_reference->save();
        //     return $this->params;
        // }

        // // Define rules
        // $rules = array(
        //     'hours_in'         => 'required|numeric|max:23|digits:2',
        //     'minutes_in'          => 'required|numeric|max:59|digits:2',
        //     'seconds_in'         => 'required|numeric|max:59|digits:2',

        //     'hours_out'         => 'required|numeric|max:23|digits:2',
        //     'minutes_out'          => 'required|numeric|max:59|digits:2',
        //     'seconds_out'         => 'required|numeric|max:59|digits:2',

        //     'day_of'          => 'required|min:3|max:10',
        // );

        // // Validate Data
        // $validator = Validator::make( $inputs , $rules );
        // if ( $validator->fails() ) {
        //     $messages = $validator->messages()->getMessages();
        //     $this->params['error'] = true;
        //     foreach ($messages as $field_name => $message) $this->params['msg'] .= '<br/>'.$message[0];
        //     return $this->params;
        // }

        // $time_in_hours = Input::get('hours_in') > 9 ? Input::get('hours_in') : Input::get('hours_in') > 0 ? '0'.Input::get('hours_in') : '00' ;
        // $time_in_minutes = Input::get('minutes_in') > 9 ? Input::get('minutes_in') : Input::get('minutes_in') > 0 ? '0'.Input::get('minutes_in') : '00' ;
        // $time_in_seconds = Input::get('seconds_in') > 9 ? Input::get('seconds_in') : Input::get('seconds_in') > 0 ? '0'.Input::get('seconds_in') : '00' ;
        // $time_in = $time_in_hours.':'.$time_in_minutes.':'.$time_in_seconds;

        // $time_out_hours = Input::get('hours_out') > 9 ? Input::get('hours_out') : Input::get('hours_out') > 0 ? '0'.Input::get('hours_out') : '00' ;
        // $time_out_minutes = Input::get('minutes_out') > 9 ? Input::get('minutes_out') : Input::get('minutes_out') > 0 ? '0'.Input::get('minutes_out') : '00' ;
        // $time_out_seconds = Input::get('seconds_out') > 9 ? Input::get('seconds_out') : Input::get('seconds_out') > 0 ? '0'.Input::get('seconds_out') : '00' ;
        // $time_out = $time_out_hours.':'.$time_out_minutes.':'.$time_out_seconds;

        // // Check if valid logout time reference
        // if( $time_out == '00:00:00' ) {
        //     $this->params['msg'] = 'Invalid time out.';
        //     $this->params['error'] = true;
        //     return $this->params;
        // }

        // // Check if valid login time reference
        // if( $time_in == '00:00:00' ) {
        //     $this->params['msg'] = 'Invalid time in.';
        //     $this->params['error'] = true;
        //     return $this->params;
        // }

        // // Check if record already exists, If so, then just update
        // $attendance_reference = AttendanceReference::whereRaw('employee_id = ? AND day = ?', array( $employee->id , $day_of) )->first();

        // if( $attendance_reference ) {
        //     // Update attendance reference
        //     $attendance_reference->login_time_reference = $time_in;
        //     $attendance_reference->logout_time_reference = $time_out;
        //     $attendance_reference->disabled = 0;
        // } else {
        //     // Create new attendance reference
        //     $attendance_reference = new AttendanceReference;
        //     $attendance_reference->employee_id = $employee->id;
        //     $attendance_reference->login_time_reference = $time_in;
        //     $attendance_reference->logout_time_reference = $time_out;
        //     $attendance_reference->day = $day_of;
        //     $attendance_reference->disabled = 0;
        // }

        // $attendance_reference->save();

        // $this->params['error'] = false;
        // $this->params['msg'] = 'Employee attendance reference has been successfully saved!';

        // return $this->params;
    }

    
    private function _update_personal_information( $inputs = null, $employee = null )
    {
        // Define rules
         $rules = array(
            'firstname'         => 'required|min:2|max:30',
            'lastname'          => 'required|min:2|max:30',
            'birthdate'         => 'required|date|date_format:"m/d/Y"|before:"now"',
            'gender'            => 'required|min:2|max:8',
            'mobile_no'         => 'min:5|max:50',
            'phone_no'          => 'min:5|max:50',
            'address'           => 'required|min:10|max:100',
        );

        $validator = Validator::make( $inputs , $rules);

        // Validate data
        if ( $validator->fails() ) {
            $messages = $validator->messages()->getMessages();
            $this->params['error'] = true;
            foreach ($messages as $field_name => $message) $this->params['msg'] .= '<br/>'.$message[0];
            return $this->params;
        }

        // Update necessary fields
        $employee->firstname                = Input::get('firstname');
        $employee->lastname                 = Input::get('lastname');
        $employee->birthdate                = date('Y-m-d', strtotime( Input::get('birthdate') ) );
        $employee->gender                   = Input::get('gender');
        $employee->mobile_no                = Input::get('mobile_no');
        $employee->phone_no                 = Input::get('phone_no');
        $employee->address                  = Input::get('address');

        $employee->save();

        $this->params['error'] = false;
        $this->params['msg'] = 'Employee personal information has been successfully updated!';
        return $this->params;
    }

    private function _update_account_details( $inputs = null, $employee = null )
    {
        // Check if email address changed. If so, add rule to check if email already exist.
        $email_rules = 'required|email';
        if( $employee->email !== Input::get('email') ) {
            $email_rules = 'required|email|unique:employees';
        }

        $password_rules = '';
        $confirm_password_rules = '';
        if(Input::get('password') !==''){
            $password_rules = 'required|min:6';
            $confirm_password_rules = 'required|same:password';
        }

        $rules = array(
            'email'             => $email_rules,
            'account_type'      => 'required|min:2|max:20',
            'identification'    => 'required|min:5|max:15',
            'status'            => 'required',
            'password'          => $password_rules,
            'confirm_password'  => $confirm_password_rules,
        );
        // Check if identification has been changed. If so, add 'UNIQUE' rules
        if( $employee->identification != Input::get('identification') ) $rules['identification'] .= '|unique:employees';

        $validator = Validator::make( $inputs , $rules);

        // Validate data
        if ( $validator->fails() ) {
            $messages = $validator->messages()->getMessages();
            $this->params['error'] = true;
            foreach ($messages as $field_name => $message) $this->params['msg'] .= '<br/>'.$message[0];
        }else{

        // Update necessary fieldss
        $employee->email                    = Input::get('email');
        $employee->identification           = Input::get('identification');
        $employee->account_type             = in_array( Input::get('account_type'), array('normal','hr', 'admin', 'owner') ) ? Input::get('account_type') : 'normal';
        $employee->status                   = Input::get('status');
        $employee->password                 = Crypt::encrypt ( Input::get('password') );
        $employee->save();

        $this->params['error'] = false;
        $this->params['msg'] = 'Employee account details has been successfully updated!';
        }

        return $this->params;
    }

    private function _update_work_details( $inputs = null, $employee = null )
    {
        $rules = array(
            'start_date'        => 'required|date|date_format:"m/d/Y"',
            'employment_status' => 'required|min:2|max:30',
            'job_title'         => 'required|min:2|max:100',
            'department_id'     => 'required|integer',
            'employment_type'   => 'required|min:2|max:30',
            'job_description'   => 'required|min:50|max:2000',
        );

        $validator = Validator::make( $inputs , $rules);

        // process the login
        if ( $validator->fails() ) {
            $messages = $validator->messages()->getMessages();
            $this->params['error'] = true;
            foreach ($messages as $field_name => $message) $this->params['msg'] .= '<br/>'.$message[0];
        } else {
            $employee->start_date               = date('Y-m-d', strtotime( Input::get('start_date') ) );
            $employee->employment_status        = Input::get('employment_status');
            $employee->job_title                = Input::get('job_title');
            $employee->department_id            = Input::get('department_id');
            $employee->employment_type          = Input::get('employment_type');
            $employee->job_description          = Input::get('job_description');

            $employee->save();

            $this->params['error'] = false;
            $this->params['msg'] = 'Employee work details has been successfully updated!!!';
        }

        return $this->params;
    }

    private function _update_profile_image( $inputs = null, $employee = null )
    {
        //Check if email address changed. If so, add rule to check if email already exist.
        $file = Request::file('profile_photo');
        if ( !Request::hasFile('profile_photo') || !$file->isValid() ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'Photo is not valid!1';
            Session::flash('flash_error', 'File is not valid!!1');
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
        if( !in_array( strtolower($extension), array('jpeg', 'jpg', 'png') ) ) {
            $this->params['error'] = true;
            $this->params['msg'] = 'File extension is not valid!';
            Session::flash('flash_error', 'File extension is not valid!!');
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

        
        Session::flash('flash_notice', 'Photo has been updated!!');
        $this->params['msg'] = 'Photo has been updated!';
        return $this->params;

    }

    function week_date($week_num, $day, $year = null ) {
        $year = $year ? $year : date('Y');
        $timestamp    = strtotime( $year . '-W' . $week_num . '-' . $day);
        return $timestamp;
    }


    function attendance($id)
    {

        // Getting Employee Attendance
        $employee = MyEmployee::find($id);
        $this->params['employee'] = $employee;
        $this->params['calendar_attendance'] = $employee->attendance;
        $this->params['what'] = 'employee_attendance';
        $this->params['action'] = 'view_attendance';
        

        return view('admin.employee.attendance', $this->params);
    }

}