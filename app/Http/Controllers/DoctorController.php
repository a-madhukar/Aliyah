<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Classes\ProfileRelated;
use App\Http\Classes\UserRelated;
use Illuminate\Http\Request;
use App\Email\NewUserEmail;
use Auth;
use Validator; 
use Log; 
use App\User;
use App\Profile; 
use App\Specialism; 
use DB; 


class DoctorController extends Controller {

	/**
	 * construct
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
		//return ProfileRelated::display();

		$doctors = DB::table('users')
					->join('profiles','profiles.user_id','=','users.id')
					->join('specialisms','specialisms.user_id','=','users.id')
					->where('users.type','=',2)
					->select('users.id','profiles.first_name','profiles.last_name','specialisms.qualification','specialisms.specialism')
					->get(); 
		return view('doctor.viewDoctor',compact('doctors')); 
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		Log::info("checks auth"); 
		if (!Auth::user()->type==1) {
			# code...
			Log::error("not authenticated. redirect to log out"); 
			return redirect('auth/logout'); 
		}
		Log::info('auth success. return the form.'); 
		return view('doctor.addDoctor'); 
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request, NewUserEmail $email)
	{
		//
		Log::info('Form posted. checking validation'); 
		$rules=$this->getSpecRules(); 

		//dd($rules); 
		$validator=Validator::make($request->all(),$rules); 
		if ($validator->fails()) {
			# code...
			Log::error("Validation failed. Returning back."); 
			return redirect()->back()->withErrors($validator); 
		}
		Log::info("Validation passed.");
		Log::info("Attempting to create the doc"); 
		$input = $request->all(); 
		$userRelated=new UserRelated; 
		//dd($input); 
		$password = UserRelated::generatePassword(); 
		//dd($password);
		$user=$this->createUser($input['email'],$password);
		//dd($user);
		if (!$user) {
		 	# code...
		 	Log::error("Error while creating the user for the doc"); 
		 	$user->delete(); 
		 } 
		 $profile=UserRelated::createProfile(
		 		$user->id,
		 		$input['first_name'],
		 		$input['last_name'],
		 		$input['address_line1'],
		 		$input['address_line2'],
		 		$input['city'],
		 		$input['state'],
		 		$input['country'],
		 		$input['postcode'],
		 		$input['phone'],
		 		$input['passport_no']
		 	); 
		 //dd($profile);
		 if (!$profile) {
		 	# code...
		 	Log::error("Error creating the profile for the doc");
		 	Log::info("will destroy both the user and the profile");
		 	$user->delete(); 
		 	$profile->delete();   
		 }
		 $specialism=$this->createSpecialism($user->id, $input['qualification'],$input['specialism']); 
		 if (!$specialism) {
		 	# code...
		 	Log::error("Error creating the specialism for the specialism");
		 	Log::info("Proceeding to destroy all three things");
		 	$user->delete(); 
		 	$profile->delete(); 
		 	$specialism->delete();   
		 }
		 $email->sendEmail($user->email,$password,"emails.newUserAccount"); 
		Log::info("Successfully created the specialism. return to the dash");
		return redirect('admin/doctor');  

	}

	/**
	 * get rules for doctor
	 */
	public function getSpecRules(){
		$rules=[
			'first_name'=>'required|string',
			'last_name'=>'required|string',
			'address_line1'=>'required|string',
			'address_line2'=>'required|string',
			'city'=>'required|string',
			'state'=>'required|string',
			'country'=>'required|string',
			'postcode'=>'required|integer',
			'phone'=>'required|string',
			'passport_no'=>'required|string',
			'qualification'=>'required|string',
			'specialism'=>'required|string',
			'email'=>'required|email|unique:users'
		]; 
		Log::info("return list of validation rules"); 
		return $rules; 
	}

		/**
	 * get rules for edit doctor
	 */
	public function getEditRules(){
		$rules=[
			'first_name'=>'required|string',
			'last_name'=>'required|string',
			'address_line1'=>'required|string',
			'address_line2'=>'required|string',
			'city'=>'required|string',
			'state'=>'required|string',
			'country'=>'required|string',
			'postcode'=>'required|integer',
			'phone'=>'required|string',
			'passport_no'=>'required|string',
			'qualification'=>'required|string',
			'specialism'=>'required|string',
		]; 
		Log::info("return list of validation rules"); 
		return $rules; 
	}

	/**
	 * create user with Doctor rights
	 */
	public function createUser($email, $password){
		Log::info("creating new user for doc"); 
		$user=User::create(['email'=>$email,'password'=>bcrypt($password),'type'=>2]);
		return $user;  
	}
	

	/**
	 * create doctor
	 */
	public function createSpecialism($user_id,$qualification,$specialism)
	{
		Log::info("creating new doctor for doc");
		$doctor=Specialism::create(['user_id'=>$user_id,'qualification'=>$qualification,'specialism'=>$specialism]);
		return $doctor;   
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
		if (Auth::user()->type!=1) {
			# code...
			return redirect()->back(); 
		}
		$profile = DB::table('users')
				->join('profiles','profiles.user_id','=','users.id')
				->join('specialisms','specialisms.user_id','=','users.id')
				->where('users.id','=',$id)
				->select('users.id','profiles.first_name','profiles.last_name','profiles.address_line1','profiles.address_line2','profiles.city','profiles.state','profiles.country','profiles.postcode','profiles.phone','profiles.passport_no','specialisms.qualification','specialisms.specialism')
				->get();
				//dd($profile);
		//$profile = User::find($id)->profiles;
		return view('doctor.editDoctor',compact('profile')); 
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,Request $request)
	{
		//
		if (Auth::user()->type!=1) {
			# code...
			return redirect()->back(); 
		}
		$rules=$this->getEditRules(); 
		$validator=Validator::make($request->all(),$rules);
		if ($validator->fails()) {
		 	# code...
		 	return redirect()->back()->withErrors($validator); 
		 } 
		$input = $request->all(); 
		$user=User::find($id);
		$profile=$user->profiles;
		$specialism=$user->specialisms; 
		$profile->update($input);
		$specialism->update($input);    
		return redirect('admin/doctor'); 
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
		if (Auth::user()->type!=1) {
			# code...
			return redirect()->back(); 
		}
		$user=User::find($id);
		$profile=$user->profiles;
		$specialism=$user->specialisms; 
		$user->delete();
		$profile->delete(); 
		$specialism->delete(); 
		return redirect('admin/doctor');  
	}

}
