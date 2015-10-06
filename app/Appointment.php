<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model {

	//
	protected $fillable = [
		'user_id',
		'appoint_date',
		'appoint_time',
		'available'
	]; 

	/**
	 *  relationship with users
	 */
	public function users(){
		return $this->belongsTo('App\User','user_id'); 
	}

	/**
	 * relationship with booking
	 */
	public function bookings(){
		return $this->hasOne('App\Booking','appointment_id'); 
	}
}
