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
use Hash;

use App\User;
use App\Employee;
use App\MyEmployee;
use App\Attendance;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller {

    public function __construct()
    {
        $this->middleware('admin');
        $this->current_user = Auth::user();
        $this->params = array(
            'error' => false,
            'redirect' => false,
            'redirect_to' => '/',
            'msg' => ''
        );

    }

    public function profile()
    {
        $this->params['page_title'] = 'My Profile';
        $this->params['current_user'] = Auth::user();

        return view('admin.profile', $this->params);
    }

    public function dashboard()
    {
        
       
        
        $this->params['page_title'] = 'Dashboard';
        $this->params['what'] = 'Dashboard';
        $this->params['action'] = 'Dashboard';
        $this->params['current_user'] = Auth::user();

        $week_start = date( 'Y-m-d', strtotime( 'monday this week' ) );
        $week_end = date( 'Y-m-d', strtotime( 'saturday this week' ) );
        
        $attendances = Attendance::whereRaw('login_time_reference >= ? AND login_time_reference <= ?', array($week_start, $week_end) )->get();
 

        $stats = (object) array(
                  'ATTENDANCE' => 0,
                  'LATES' => 0,
                  'ABSENCES' => 0,
                  'att' => (object) array(),
                  ) ;



        /* GRAPH DATA */
        $attendance_count = DB::table('attendance')->select(DB::raw('count(login_time_reference) as present, login_time_reference'))->groupby('login_time_reference')->get();
        $this->params['attendance_count'] = $attendance_count;


        /* TOP EMPLOYESS */
        $top_employees = array();
        $employees = MyEmployee::All();
        foreach ($employees as $Employee => $value) {
            $emp = (object) array('employee' => $value, 'ontime' => $value->totalOntime());
            array_push($top_employees, $emp);
        }
        
        // Manual Sorting of ontime employees
        for ($i=0; $i < count($top_employees); $i++) { 
            
            for ($j=$i; $j < count($top_employees); $j++) { 
                
                if($top_employees[$j]->ontime > $top_employees[$i]->ontime){

                    $temp = $top_employees[$i];
                    $top_employees[$i] = $top_employees[$j];
                    $top_employees[$j] = $temp;
                }
            
            }   

        }

        //dd($top_employees);

        $this->params['top_employees'] = $top_employees;


        return view('admin.dashboard', $this->params);
    }
}