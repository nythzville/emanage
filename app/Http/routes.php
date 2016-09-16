<?php
/*
|--------------------------------------------------------------------------
| Administrator Routes
|--------------------------------------------------------------------------
|
| Here is where the users have the right to view, edit, delete employees.
| Dashbaord menus will depend on admin rights classsified as (admin, hr, owner).
| In these routes, can be also be found the routes for personal profile of admins.
|
*/
use Illuminate\Support\Facades\Auth;
Route::filter('cache', function( $response = null )
{

    $uri = URI::full() == '/' ? 'home' : Str::slug( URI::full() );

    $cached_filename = "response-$uri";

    if ( is_null($response) )
    {
        return Cache::get( $cached_filename );
    }
    else if ( $response->status == 200 )
    {
        $cache_time = 30; // 30 minutes

        if ( $cache_time > 0 ) {
            Cache::put( $cached_filename , $response , $cache_time );
        }
    }

});


// Login routes....
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('/admin/dashboard', function(){ return Redirect::to('/admin'); });

Route::get('/admin', 'AdminController@dashboard');
Route::get('/admin/employee/{id}/attendance', 'AdminEmployeeController@attendance');
Route::resource('admin/employee', 'AdminEmployeeController');

// Route::resource('admin/leaves', 'AdminLeavesController');
// Route::get('admin/leaves/{id}/{what}', 'AdminLeavesController@show');
// Route::post('admin/leaves/{id}/update/{what}', 'AdminLeavesController@update');
// Route::get('admin/profile', 'AdminController@profile');
// Route::get('admin/employee/attendance/today', 'AdminAttendanceController@index');
// Route::get('admin/employee/attendance/{id}/show_attendance', 'AdminAttendanceController@show');

// Route::resource('admin/employee/{id}/work_details', 'AdminEmployeeController@work_details');
//Route::get('admin/employee/{id}/{what}', 'AdminEmployeeController@show');
//Route::post('admin/employee/{id}/update/{what}', 'AdminEmployeeController@update');
// Route::resource('admin/attendance', 'AdminAttendanceController');
// Route::get('admin/employee/attendance/review_attendance', 'AdminAttendanceController@view');


/*
|--------------------------------------------------------------------------
| Login and Logout Routes
|--------------------------------------------------------------------------
|
| Here is where the employee can edit their passwords, view profile, view statistics
| can apply leave, view tardiness, attendance, etc.
| In these routes, can be also be found the routes for personal profile settings.
|
*/

// Route::post('/login', 'LoginController@index');

Route::get('/', array(function () {
    
    if( !Auth::check() )

        return Redirect::to('/auth/login');

    else {

        if(  Auth::user()->user_type == 'Admin' ) return Redirect::to('/admin')->with('flash_notice', 'You are successfully logged in.');
        
        return Redirect::to('/employee/profile')->with('flash_notice', 'You are successfully logged in.');
    }
}));


// Route::get('/login', array('as' => 'login', function () {
// 	if ( Auth::check() ) {
//         if( in_array( Auth::user()->account_type, Config::get('app.admins') ) )
//         	return Redirect::to('admin/employee');
//         return Redirect::to('employee/attendance');
//     }
//     return View::make('employees.login2', array('page_title' => 'Login') );
// }));

// Route::get('/logout', array('as' => 'logout', function () {
//     Auth::logout();
//     $this->params['error'] = false;
//     $this->params['msg'] = 'You have successfully logged out.';
//     return Redirect::to('/login')
//         ->with($this->params);
// }))->before('auth');


/*
|--------------------------------------------------------------------------
| Normal Employeee Routes
|--------------------------------------------------------------------------
|
| Here is where the employee can edit their passwords, view profile, view statistics
| can apply leave, view tardiness, attendance, etc.
| In these routes, can be also be found the routes for personal profile settings.
|
*/

Route::get('employee/profile', 'EmployeeController@profile');

// Route::get('employee/dashboard', 'DashboardController@dashboardview');
// Route::get('admin/dashboard', 'DashboardController@dashboardview');
// Route::get('leaves/{what}', 'EmployeeLeavesController@show');
// Route::resource('leaves', 'EmployeeLeavesController');
// Route::get('employee/{what}', 'EmployeeController@show');
// Route::get('employee/attendance_report', 'EmployeeController@show');
Route::post('employee/attendance/login', 'EmployeeController@attendance_login');
// Route::post('employee/attendance/break', 'EmployeeController@attendance_break');
// Route::post('employee/attendance/stopbreak', 'EmployeeController@attendance_stopbreak');
// Route::post('employee/attendance/logout', 'EmployeeController@attendance_logout');
// Route::resource('employee', 'AdminEmployeeController');
// Route::post('employee/{id}/update/{what}', 'EmployeeController@update');
// Route::post('employee/createpost','DashboardController@postCreatePost');
// Route::post('employee/editpost','DashboardController@postEditPost');
// Route::post('employee/deletepost','DashboardController@postDeletePost');
// Route::post('admin/createpost','DashboardController@postCreatePost');
// Route::post('admin/editpost','DashboardController@postEditPost');
// Route::post('admin/deletepost','DashboardController@postDeletePost');


//Route::post('employee/leave_form', 'EmployeeController@leaves');


/*Route::get('recover/password', 'UsersController@recover_password');
Route::get('forgot/password/recovery_confirmation/{user_uid}/{recovery_confirmation_link}', 'UsersController@recovery_confirmation');
Route::get('edit/email', 'UsersController@edit_email');
Route::get('edit/password', 'UsersController@edit_password');
Route::get('profile', 'UsersController@edit');


Route::post('update/password', 'UsersController@update_password');
Route::post('recover/password', 'UsersController@recover_password_submit');
Route::post('forgot/password/new_password', 'UsersController@new_password');
Route::post('update/email', 'UsersController@update_email');*/

/*
|--------------------------------------------------------------------------
| Cronjobs Routes
|--------------------------------------------------------------------------
|
| In this route you will specify method that needs to run in cronjobs. This is very important
| in the system to automate necessary functionalities.
|
*/

//Route::get('crons/attendance_creation', 'CronsController@attendance_creation');

/*
|--------------------------------------------------------------------------
| Wrong Route Redirection (Added by John Eiman Mission)
|--------------------------------------------------------------------------
|
| The wrong links eneterd in the URL bar will redirect to the homepage.
|
*/
// Route::get('/{any}', function($any){
//     return Redirect::to('/');
// })->where('any', '.*');


