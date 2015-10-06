<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator; 
use App\User; 
use App\Profile; 
use App\Booking; 
use DB; 

class PatientController extends Controller {

	//
	public function searchPatient(Request $request){
		//dd($request->all()); 
		$rules=[
			'first_name'=>'required|string'
		]; 
		$validator=Validator::make($request->all(),$rules);
		if ($validator->fails()) {
		 	# code...
		 	return redirect()->back()->withErrors($validator); 
		} 

		$user=DB::table('users')
				->join('profiles','profiles.user_id','=','users.id')
				->where('users.type','=',4)
				->where('profiles.first_name','=',$request->get('first_name'))
				->select('users.id','profiles.first_name','profiles.last_name','profiles.address_line1','profiles.address_line2','profiles.city','profiles.state','profiles.country','profiles.postcode','profiles.phone','profiles.passport_no')
				->get(); 

		return view('patient.foundPatient',compact('user')); 

	}

	/**
	 * get booking history for patient
	 */ 
	public function getBookingHistory($id){
		$history = DB::table('users')
					->join('bookings','bookings.user_id','=','users.id')
					->where('users.id','=',$id)
					->join('appointments','appointments.id','=','bookings.appointment_id')
					->join('profiles','profiles.user_id','=','appointments.user_id')
					->select('profiles.first_name','profiles.last_name','appointments.appoint_date','appointments.appoint_time')
					->orderBy('appointments.appoint_date','desc')
					->orderBy('appointments.appoint_time','desc')
					->get(); 
		return view('patient.bookingHistory',compact('history')); 
	} 

}
