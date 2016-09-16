<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class MyEmployee extends Model implements AuthenticatableContract  {

	use Authenticatable;

	protected $primaryKey = 'id';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'employee_lists';



    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function attendance()
    {
        return $this->hasMany('App\Attendance', 'employee_id');
    }

    public function attendanceReference()
    {
        return $this->hasMany('App\AttendanceReference', 'employee_id');
    }

    public function totalOntime(){

    	return $this->hasMany('App\Attendance', 'employee_id')->where('status', 'ONTIME')->count();
    }

    public function totalLate(){

    	return $this->hasMany('App\Attendance', 'employee_id')->where('status', 'LATE')->count();
    }


}
