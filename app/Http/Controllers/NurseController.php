<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Classes\UserRelated;
use Illuminate\Http\Request;
use App\Email\NewUserEmail;
use App\User; 
use App\Responsibility; 
use Auth;
use Validator; 
use Log; 
use DB;

class NurseController extends Controller {

	/**
	 * this is the construct
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
		$nurses = DB::table('users')
					->join('profiles','profiles.user_id','=','users.id')
					->join('responsibilities','responsibilities.user_id','=','users.id')
					->where('users.type','=',3)
					->select('users.id','profiles.first_name','profiles.last_name','responsibilities.ward')
					->get(); 
		return view('nurse.viewNurse',compact('nurses'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		if (!Auth::user()->type==3) {
			# code...
			return redirect('auth/logout'); 
		}
		return view('nurse.addNurse'); 
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request,NewUserEmail $email)
	{
		//
		Log::info("Submitting the add nurse form"); 
		$rules=$this->getNurseValRules(); 
		$validator=Validator::make($request->all(),$rules); 
		if ($validator->fails()) {
			# code...
			Log::error("Failed validation submitting the nurse form");
			return redirect()->back()->withErrors($validator);  
		}
		Log::info("Validation passed");
		$input = $request->all(); 
		Log::info("Creating the user");
		Log::info("generating a random password"); 
		$password = UserRelated::generatePassword(); 
		$user=$this->createUser($input['email'],$password);  
		if (!$user) {
			# code...
			Log::error("Failed to create user for nurse");
			$user->delete();  
			return redirect()->back()->withErrors("Failed to create user for nurse"); 
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
		if (!$profile) {
			# code...
			Log::error("Error creating the profile for the nurse");
			$user->delete(); 
			$profile->delete();  
			return redirect()->back()->withErrors("Error creating the profile for the nurse"); 
		}
		$resp = $this->createResponsibility($user->id,$input['ward']); 
		if (!$resp) {
			# code...
			Log::error("failed to create the responsibility");
			$user->delete(); 
			$profile->delete();  
		}
		$email->sendEmail($user->email,$password,"emails.newUserAccount"); 
		Log::info("created the nurse");
		return redirect('admin/nurse');  
	}

	/**
	 * get the validation rules
	 */
	public function getNurseValRules(){
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
			'ward'=>'required|string',
			'email'=>'required|email|unique:users'
		];
		return $rules; 
	}

	/**
	 * get the edited validation rules
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
			'ward'=>'required|string'
		];
		return $rules; 
	}

	/**
	 * create user for nurse
	 */
	public function createUser($email,$password){
		$user = User::create(['email'=>$email,'password'=>bcrypt($password),'type'=>3]);
		return $user;  
	}

	/**
	 * create the responsibility
	 */
	public function createResponsibility($user_id,$ward){
		$resp = Responsibility::create([
				'user_id'=>$user_id,
				'ward'=>$ward]);
		return $resp; 
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
				->join('responsibilities','responsibilities.user_id','=','users.id')
				->where('users.id','=',$id)
				->select('users.id','profiles.first_name','profiles.last_name','profiles.address_line1','profiles.address_line2','profiles.city','profiles.state','profiles.country','profiles.postcode','profiles.phone','profiles.passport_no','responsibilities.ward')
				->get();
				//dd($profile);
		//$profile = User::find($id)->profiles;
		return view('nurse.editNurse',compact('profile'));
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
		$responsibilities=$user->responsibilities; 
		$profile->update($input);
		$responsibilities->update($input);    
		return redirect('admin/nurse'); 
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
		$responsibilities=$user->responsibilities; 
		$user->delete();
		$profile->delete(); 
		$responsibilities->delete(); 
		return redirect('admin/nurse');
	}

}
