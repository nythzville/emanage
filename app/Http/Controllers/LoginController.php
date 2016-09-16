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

use App\Employee;

class LoginController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | AUTHOR: BORN0101CODE
    | LOGIN LOGIC
    |--------------------------------------------------------------------------
    |
    */

    public function __construct()
    {
        $this->params = array(
            'error' => false,
            'redirect' => false,
            'redirect_to' => '/',
            'msg' => ''
        );

    }


    function index()
    {

        $employee = Employee::whereRaw('email = ? and status = \'ACTIVE\'', array(Input::get('email')))->first();
        $password = Input::get('password');

        if( $employee && $employee->password ) {

            // Now, check if employee has the same password and logged employee
            $decrypted_password = Crypt::decrypt($employee->password);
            if( $decrypted_password === $password ) {

                Auth::login( $employee );

                if ( Request::ajax() ) {

                    $this->params['error'] = false;
                    $this->params['msg'] = 'You are successfully logged in. Please wait while redirecting.';
                    $this->params['redirect'] = true;

                    // Check if employee with admin rights
                    if( in_array( $employee->account_type, Config::get('app.admins') ) )
                        $this->params['redirect_to'] = 'admin/employee';
                    else
                        $this->params['redirect_to'] = 'employee/attendance';

                    return Response::json($this->params);
                    
                } else {
                     // Check if employee with admin rights
                    if( in_array( $employee->account_type, Config::get('app.admins')) )

                        return Redirect::to('/admin/employee')->with('flash_notice', 'You are successfully logged in.');
                    
                    return Redirect::to('/employee/attendance')->with('flash_notice', 'You are successfully logged in.');
                }
            }
        }

        // authentication failure! lets go back to the login page
        $this->params['error'] = true;
        $this->params['msg'] = 'Your email/password combination was incorrect.';

        if ( Request::ajax() )
            return Response::json($this->params);

        return Redirect::route('login')
            ->with($this->params)
            ->withInput();
    }

}