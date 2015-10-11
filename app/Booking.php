<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {


	//
	protected $fillable = [
		'appointment_id',
		'user_id'
	]; 

	/**
	 * relationship with appointment
	 */
	public function appointments(){
		return $this->belongsTo('App\Appointment','appointment_id');
	}

	/**
	 * relationship with users
	 */
	public function users(){
		return $this->belongsTo('App\User','user_id'); 
	}

	/**
	 * relationship with prescription
	 */
	public function prescriptions(){
		return $this->hasMany('App\Prescription','booking_id'); 
	}

}
