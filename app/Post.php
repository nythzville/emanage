<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	public function empl(){
		return $this->belongsTo('App\Employee', 'employee_id', 'id');
	}
}
