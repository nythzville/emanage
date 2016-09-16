<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Employee extends Model implements AuthenticatableContract  {

	use Authenticatable;

	protected $primaryKey = 'id';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'employees';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	//protected $fillable = ['user_fname', 'user_email', 'user_password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


	public function attendance()
    {
        return $this->hasMany('App\Attendance', 'employee_id');
    }

    public function attendance_reference()
    {
        return $this->hasMany('App\AttendanceReference', 'employee_id');
    }

    public function leaves()
    {
        return $this->hasMany('App\Leaves', 'employee_id');
    }
    
    public function  posts(){
		return $this->hasMany('App\Post');
	}
    

}
