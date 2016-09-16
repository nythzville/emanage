<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Leaves extends Model {

	protected $table = 'leaves';

	public function employee()
    {
        return $this->hasOne('App\Employee', 'id', 'employee_id');
    }

}
