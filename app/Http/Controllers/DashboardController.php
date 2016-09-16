<?php namespace App\Http\Controllers;
use Validator;
use Input;
use Crypt;
use Eloquent;
use Response;
use URL;
use Auth;
use Redirect;
use Config;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Leaves;
use App\Employee;
use App\Department;
use App\AttendanceReference;
use App\Attendance;
use App\Post;
use App\Quote;
use Illuminate\Foundation\Validation\ValidatesRequests;
class DashboardController extends Controller {

	 /*
    |--------------------------------------------------------------------------
    | ADDED BY: JOHN EIMAN MISSION
    | DASHBOARD CONTROLLER
    |--------------------------------------------------------------------------
    |
    */

	function week_date($week_num, $day, $year = null ){
        $year = $year ? $year : date('Y');
        $timestamp    = strtotime( $year . '-W' . $week_num . '-' . $day);
        return $timestamp;
    }

	public function dashboardview($what = null){

		if(Auth::user()->account_type == 'admin'){
			$this->params['mainmenu'] = 'admin';
		}
		else{
			$this->params['mainmenu'] = 'employee';
		}

        $this->employee = Auth::user();
        $this->params['employee'] = Auth::user();
        $from   = date('Y-m-d 00:00:00', time());
        $to     = date('Y-m-d 23:59:59', time());
        // test only
        // $this->params['employees'] = Employee::where('status', 'ACTIVE')
        //         ->whereMonth('birthdate', '=', '08')
        //        ->get();
        // die(var_dump($this->params['employees']));
        
        $this->params['employees'] = Employee::where('status', 'ACTIVE')
                ->whereMonth('birthdate', '=', date('m', time()))
               ->get();
        $week_start = date('Y-m-d 00:00:00',$this->week_date(date("W"), 0 ));
        $week_end = date('Y-m-d 00:00:00',$this->week_date(date("W"), 6 ));

        $this->params['logins'] = Attendance::whereRaw('login_time_reference >= ? AND login_time_reference < ? AND status != "ABSENT"', array($from, $to) )->orderBy('login_time', 'desc')->take(12)->get();

        $this->params['menu_action'] = 'view_dashboard';
        $this->params['attendance_reference'] = $this->employee->attendance_reference->where('disabled', '=', 0);

        $this->params['emp'] = Auth::user();
        $this->params['what'] = "";
        $this->params['posts'] = Post::where('created_at', '>=', date(('Y-m-d').' 00:00:00'))->orderBy('created_at', 'desc')->get();

        $random_number = rand(1, count(Quote::all()));
        $this->params['quote'] = Quote::find($random_number);
        return view('employees.employee-admin-dashboard', $this->params);
    }

    // FUNCTION TO CREATE A POST
    public function postCreatePost(Request $request){
        $this->params['employee'] = Auth::user();
		$this->validate($request, [
			'body' => 'required|max:1000'
		]);
		$post = new Post();
		$post->body = $request['body'];
		$message = 'There was an error.';
		$post->employee_id = Auth::user()->id;
		if($post->save()){
			$message = 'Posted!';
		}
		$image = $post->empl->photo;
		if(!($post->empl->photo)){
			if($post->empl->gender == 'male'){
				$image = 'male-default-photo-50.jpg';
			}
			else{
				$image = 'female-default-photo-50.jpg';
			}
		}
		return response()->json(['image' => $image,
			'employeename' => $post->empl->firstname.' '.$post->empl->lastname,
			'date' => date("g:i A", strtotime($post->created_at)),
			'id' => $post->id,
			'post' => nl2br(($post->body))]);
	}

	// FUNCTION TO EDIT YOUR OWN POST
	public function postEditPost(Request $request){
		$this->validate($request, [
			'body' => 'required|max:1000'
		]);
		$post = Post::find($request['postId']);
		$post->body = $request['body'];
		$message = 'There was an error.';
		$post->update();
		return response()->json(['edited' => $request['body']]);
	}

	// FUNCTION TO DELETE YOUR OWN POST
	public function postdeletePost(Request $request){
		$post = Post::find($request['postId']);
		$post->delete();
		return response()->json(['status' => 'success']);
	}
}