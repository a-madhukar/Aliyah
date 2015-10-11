<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model {

	//
	protected $fillable = [
		'booking_id',
		'sickness',
		'prescription',
		'description'
	]; 

	/**
	 * relationship with booking
	 */
	public function bookings(){
		return $this->belongsTo('App\Booking','booking_id');
	}

}
