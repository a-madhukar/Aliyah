<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth; 
use Log; 
use DB; 
use App\Specialism;


class SearchController extends Controller {

	/**
	 * define the constructor 
	 */
	public function __construct(){
		$this->middleware('auth'); 
	}

	/**
	 * get the search form
	 */
	public function getSearchForm(Request $request){
		//dd($request->get('specialisms'));
		$specialists=$this->getSpecialists($request->get('specialisms'));
		//$specialismList=$this->getSpecialismList();  
		return view('booking.specialists',compact('specialists'));  
	}

	public function getSpecialismList(){
		return Specialism::lists('specialism'); 
	}

	/**
	 * list all specialists 
	 */
	public function getSpecialists($specialism){
		$specialists = DB::table('specialisms')
						->join('profiles','profiles.user_id','=','specialisms.user_id')
						->where('specialisms.specialism','=',$specialism)
						->select('specialisms.user_id as user_id','specialisms.id as specialism_id','profiles.first_name','profiles.last_name','specialisms.qualification','specialisms.specialism')
						->get(); 
		return $specialists; 
	}

	/**
	 *  get selected specialist
	 */
	public function searchSpecialist(){

	}


}
