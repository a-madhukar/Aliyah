<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth; 
use Validator; 
use Log; 
use App\Appointment;
use App\Specialism;
use App\User; 
use App\Booking; 
use Carbon\Carbon; 
use DB;

class AppointmentController extends Controller {

	/**
	 * define the constructor
	 */
	public function __construct(){
		$this->middleware('auth'); 
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		if (Auth::user()->type==4 || Auth::user()->type==3) {
			# code...
			return redirect()->back(); 
		}
		//dd($this->getTodayAppointments());
		$todays = $this->getTodayAppointments(); 
		$upcomings = $this->getUpcomingAppointments(); 
		$availables = $this->getAvailableBookings(); 
		//dd($availables);
		return view('appointments.addAppointment',compact('todays','upcomings','availables'));
	}

	/**
	 * get Today's carbon instance;
	 */
	public function getCarbonInstance(){
		return Carbon::now('Asia/Kuala_Lumpur'); 
	}


	/**
	 * get today's appointments 
	 */
	public function getTodayAppointments(){
		$date=$this->getCarbonInstance()->toDateString(); 
		$appointments = DB::table('appointments')
						->where('appointments.appoint_date','=',"".$date)
						->join('bookings','bookings.appointment_id','=','appointments.id')
						->join('profiles','profiles.user_id','=','bookings.user_id')
						->select('appointments.id as appointment_id','profiles.user_id as user_id','profiles.id as profile_id','bookings.id as booking_id','appointments.appoint_date','appointments.appoint_time','profiles.first_name','profiles.last_name')
						->orderBy('appointments.appoint_time','desc')
						->get(); 
		return $appointments;
	}

	/**
	 *  get available bookings
	 */
	public function getAvailableBookings(){
		return Appointment::where('available',1)->orderBy('appoint_date','asc')->orderBy('appoint_time','asc')->get(); 
	}

	/**
	 *  get upcoming appointments 
	 */
	public function getUpcomingAppointments(){
		$date=$this->getCarbonInstance()->toDateString(); 

		$upcoming=DB::table('appointments')
					->where('appointments.appoint_date','>',$date)
					->join('bookings','bookings.appointment_id','=','appointments.id')
					->join('profiles','profiles.user_id','=','bookings.user_id')
					->select('appointments.id as appointment_id','profiles.user_id as user_id','profiles.id as profile_id','bookings.id as booking_id','appointments.appoint_date','appointments.appoint_time','profiles.first_name','profiles.last_name')
						->orderBy('appointments.appoint_time','desc')
					->get(); 
		return $upcoming; 
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		//
		$rules=$this->getAppointValRules(); 
		//dd($request->all()); 
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
		 	# code...
			return redirect()->back()->withErrors($validator); 
		 } 
		 $input=$request->all(); 
		 $appointment = Appointment::create(
		 	[
		 		'user_id'=>Auth::user()->id,
		 		'appoint_date'=>$input['appoint_date'],
		 		'appoint_time'=>$input['appoint_time'],
		 		'available'=>true
		 	]); 
		 return redirect('doctor/appointment'); 
	}

	/**
	 *  set the validation rules for the appointment
	 */
	public function getAppointValRules(){
		$rules=[
			'appoint_date'=>'required|date',
			'appoint_time'=>'required'
		]; 
		return $rules;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * get available appointments for the specialist
	 */
	public function getApptForSpecialist($id){
		$user=User::findOrFail($id);
		$profile=$user->profiles; 
		$appointments=$user->appointments->where('available','1');
		return view('appointments.availAppointments',compact('appointments','profile'));  
	}

	/**
	 * make booking for the user
	 */
	public function makeBooking(Request $request){
		//dd($request->get('booking')); 
		if (Auth::user()->type!=4) {
			# code...
			return redirect()->back(); 
		}

		$val=$this->customValidation($request->get('booking')); 
		if ($val==0) {
			# code...
			return redirect()->back()->withErrors("You haven't made a booking."); 
		}elseif($val>1){
			return redirect()->back()->withErrors("You can only book one appointment at a time."); 
		}
		foreach ($request->get('booking') as $_temp) {
			# code...
			if ($_temp!="none") {
				# code...
				$appointId=$_temp; 
			}
		}
		//dd($appointId);
		$appointment = Appointment::findOrFail($appointId); 
		if ($appointment->available==1) {
			# code...
			$booking = Booking::create(['appointment_id'=>$appointment->id,'user_id'=>Auth::user()->id]);
			$appointment->update(['available'=>0]); 
			return redirect('home/patient'); 
		}
		return redirect()->back()->withErrors("Error creating the booking"); 
	}

	/**
	 * custom validation for the booking
	 */
	public function customValidation($input){
		$_count=0; 
		//dd($input);
		foreach ($input as $_input) {
			# code...
			//echo($_input);
			if ($_input!="none") {
				# code...
				//echo("".$_input); 
				$_count++; 
			}
		}
		return $_count;

	}

}
