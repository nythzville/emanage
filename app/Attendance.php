<?php namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {

	protected $table = 'attendance';

    public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

    public function date_attendance(){

    	//return $this->distinct('reference_time_login')->count('reference_time_login');
    }
}
