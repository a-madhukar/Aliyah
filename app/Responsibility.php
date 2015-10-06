<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Responsibility extends Model {

	//
	protected $fillable = [
		'user_id',
		'ward'
	]; 

	public function users(){
		return $this->belongsTo('App\User','user_id'); 
	}

}
