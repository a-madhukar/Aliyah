<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Classes\ProfileRelated;
use Illuminate\Http\Request;
use Auth; 
use Validator; 
use App\User; 
use App\Profile;
use Log;
use Session;
use App\Specialism;

class AuthController extends Controller {

	//

	public function getLoginForm(){

		if (Auth::check()) {
			# code...
			$this->logout();
		}
		return view('auth.login'); 
	}

	//logs the user in 
	//1= Admin
	//2 = Doctor
	//3 = Nurse
	//4 = Patient
	public function login(Request $request){

		if (Auth::check()) {
			# code...
			return redirect()->back(); 
		}

		$rules = [
			'email'=>'required|email',
			'password'=>'required',
		];

		$validator = Validator::make($request->all(),$rules); 
		if ($validator->fails()) {
			# code...
			return redirect()->back()->withErrors($validator); 
		}

		$input = $request->all(); 

		//attempt to login 
		if (Auth::attempt(['email'=>$input['email'],'password'=>$input['password'],'type'=>1])) {
			//$user = Auth::user(); 
			//dd($user);

			return redirect('admin/doctor');
		}elseif (Auth::attempt(['email'=>$input['email'],
				'password'=>$input['password'],'type'=>2
			])) {
			# code...
			//$user = Auth::user(); 
			//dd($user);

			return redirect('doctor/appointment');
		}elseif (Auth::attempt(['email'=>$input['email'],'password'=>$input['password'],'type'=>3])) {
			# code...
			//$user = Auth::user(); 
			//dd($user);

			return redirect('nurse/appointments');
		}elseif (Auth::attempt(['email'=>$input['email'],'password'=>$input['password'],'type'=>4])) {
			# code...
			//$user = Auth::user(); 
			//dd($user);
			$specialismList=$this->getSpecialismList();
			Session::put('specialismList',$specialismList);

			return redirect('patient/history/booking');
		}

		dd("login Failed");
	}


	public function getSpecialismList(){
		return Specialism::lists('specialism'); 
	}

	public function getSignUpForm(){
		if (Auth::check()) {
			# code...
			return redirect()->back(); 
		}

		Log::info("get Sign Up Form");
		 Log::info("checking to see if a session exists"); 
		 if (Session::has('sign_up_user_id')) {
		 	# code...
		 	Log::info("session sign_up_user_id exists");
		 	Log::info("deleting session sign_up_user_id");
		 	Session::forget('sign_up_user_id'); 
		 }
		 Log::info("no sign_up_user_id session, proceeding to register form"); 
		return view('auth.register'); 
	}

	//signs the patient in 
	// along with the doctor, nurse & admin
	public function signUp(Request $request){
		$rules=[
			'email'=>'required|email|unique:users',
			'password'=>'required|confirmed',
			'password_confirmation'=>'required'
		];
		$validator = Validator::make($request->all(),$rules);
		if ($validator->fails()) {
		 	# code...
		 	return redirect()->back()->withErrors($validator); 
		 } 
		Log::info("passed validation. submitting the sign up form"); 
		 $input = $request->all(); 
		 $user = User::create(['email'=>$input['email'],'password'=>bcrypt($input['password']),'type'=>4]);
		 Log::info("attempting to create user");
		 if ($user) {
		   	# code...
		   	Log::info("Created the user"); 
		   	if (!Session::has('sign_up_user_id')) {
		   		# code...
		   		Session::put('sign_up_user_id',$user->id);
		   		Log::info("created the session.Id: ".Session::get('sign_up_user_id')); 
		   		return redirect('auth/profile');   		
		   	}
		   	Log::error("Session already exists for the same user. Session: ".Session::get('sign_up_user_id')); 
		} 
		$user->delete();  
		Log::error("Error creating the user"); 
		Log::error("Destroying the created user");
	}

	/**
	 * log the user out
	 */
	public function logout(){
		if (Auth::check()) {
			# code...
			Auth::logout(); 
		}
		return redirect('/'); 
	}

	/**
	 * get Profile Form
	 */
	public function getProfileForm(){
		if (Auth::check()) {
			# code...
			$this->logout();
		}
		Log::info("requesting get profile form"); 
		if (Session::has('sign_up_user_id')) {
			# code...
			$sign_up_user_id=Session::get('sign_up_user_id');
			return view('auth.setupProfile',compact('sign_up_user_id')); 
		}
		Log::error("couldn't find the session when creating the profile"); 
		return redirect('auth/signup');  
		//return view('auth.setupProfile');  
	}

	/**
	 * get data from input and create profile
	 */
	public function setupProfile(Request $request){
		if (Auth::check()) {
			# code...
			$this->logout(); 
		}
		Log::info("Setting up the profile");
		Log::info("Checking validating rules");  
		
		$validator=Validator::make($request->all(),ProfileRelated::getValRulesForProfiles());
		if ($validator->fails()) {
		 	# code...
		 	Log::warning("Validation failed.Returning back");
		 	return redirect()->back()->withErrors($validator); 
		 } 
		 Log::info("Validation passed. creating profile");
		 if (!Session::has('sign_up_user_id')) {
		 	# code...
		 	Log::error("sign_up_user_id Session doesn't exist");
		 	return redirect()->back()->withErrors("You need to sign up before creating the profile"); 
		 }
		 $input=$request->all(); 
		 Log::info("attempting to create the profile instance"); 
		 if ($profile=ProfileRelated::createProfileInstance(Session::get('sign_up_user_id'),$input)) {
		 	# code...
		 	Log::info("created the profile Instance");
		 	return redirect('auth/login');  
		 }
		 Log::error("failed to create the profile instance");
		 return redirect()->back()->withErrors("Failed to create the Profile"); 
		
	}

	//these are the rules for the validation
	//when creating a profile 
/*	public function getValRulesForProfiles(){
		$rules=[
			'first_name'=>'required',
			'last_name'=>'required',
			'address_line1'=>'required',
			'address_line2'=>'required',
			'city'=>'required',
			'state'=>'required',
			'country'=>'required',
			'postcode'=>'required',
			'phone'=>'required',
			'passport_no'=>'required'
		]; 
		return $rules; 
	}

	//create the profile 
	public function createProfileInstance($userId,$input){
		$profile=Profile::create(
				[
					'user_id'=>$userId,
					'first_name'=>$input['first_name'],
					'last_name'=>$input['last_name'],
					'address_line1'=>$input['address_line1'],
					'address_line2'=>$input['address_line2'],
					'city'=>$input['city'],
					'state'=>$input['state'],
					'country'=>$input['country'],
					'postcode'=>$input['postcode'],
					'phone'=>$input['phone'],
					'passport_no'=>$input['passport_no']
				]
			); 
		return $profile; 
	}

	public function display(){
		return "This works";
	} */ 

}
