<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB; 
use Auth;
use Session;
use App\Prescription;
use Validator;

class PrescriptionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
		//dd($request->all());
		$rules= $this->getValidation(); 
		$validator = Validator::make($request->all(),$rules); 
		if ($validator->fails()) {
			# code...
			return redirect()->back()->withErrors($validator); 
		}
		$input = $request->all();
		$prescription=Prescription::create(
			[
				'booking_id'=>$input['booking_id'],
				'sickness'=>$input['sickness'],
				'prescription'=>$input['prescription'],
				'description'=>$input['description']
			]);
		return redirect('/prescription/'.$prescription->id); 
		//return view('prescription.preview',compact('prescription')); 
	}

	/**
	 * return validation rules
	 */
	public function getValidation(){
		return [
			'booking_id'=>'required|integer',
			'sickness'=>'required',
			'prescription'=>'required',
			'description'=>'required'
		];
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
		$prescription=Prescription::find($id);
		//dd($prescription);
		return view('prescription.preview',compact('prescription'));
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
		$prescription=Prescription::find($id);
		return view('prescription.editPrescription',compact('prescription'));
		//return redirect('/prescription/'.$prescription->id); 

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request)
	{
		//
		$rules= $this->getValidation(); 
		$validator = Validator::make($request->all(),$rules); 
		if ($validator->fails()) {
			# code...
			return redirect()->back()->withErrors($validator); 
		}
		//$input = $request->all();
		$prescription=Prescription::find($id);
		$prescription->update($request->all());
		return redirect('/prescription/'.$prescription->id); 

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
		$prescription=Prescription::find($id);
		$prescription->delete(); 
		return redirect('/doctor/appointment');
	}

	/**
	 *  view medical history for the patient
	 */
	public function viewHistory(){
		if (Auth::check()) {
			# code...
			if (Auth::user()->type==4) {
				# code...
				$history = $this->medicalHistoryQuery(Auth::user()->id);  
				//Session::put('booking_id',$bookingId); 
				return view('records.patientRecord',compact('history'));
			}
			return redirect()->back(); 
		}
		return redirect()->back(); 		
	}


	/**
	 * prepare getMedical history
	 */
	public function getMedicalHistory($userId,$bookingId){
		//dd($this->medicalHistoryQuery($userId));
		$history = $this->medicalHistoryQuery($userId);  
		Session::put('booking_id',$bookingId); 
		return view('records.patientRecord',compact('history')); 
	}

	/**
	 * create medical history query
	 */
	public function medicalHistoryQuery($userId){
		$history= DB::table('bookings')
					->where('bookings.user_id','=',$userId)
					->join('prescriptions','prescriptions.booking_id','=','bookings.id')
					->join('appointments','appointments.id','=','bookings.appointment_id')
					->select('bookings.user_id as user_id','bookings.id as booking_id','prescriptions.sickness','prescriptions.prescription','prescriptions.description','appointments.appoint_date as date')
					->orderBy('appointments.appoint_date','desc')
					->get(); 
		return $history; 
	}

}
