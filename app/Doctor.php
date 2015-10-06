<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model {

	//
	protected $fillable=[
		'user_id',
		'qualification',
		'specialism'
	]; 

	public function users(){
		return $this->belongsTo('App\User','user_id'); 
	}

}
