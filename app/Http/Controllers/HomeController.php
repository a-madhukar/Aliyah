<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth; 
use DB;
use App\Specialism;
use Session;

class HomeController extends Controller {

	//admin home
	public function admin(){
		if (Auth::check()) {
			# code...
			return view('dash.admin');
		}
		return redirect('auth/logout');
	}

	//doctor home
	public function doctor(){
		if (Auth::check()) {
			# code...
			return view('dash.doctor');
		}

		return redirect('auth/logout');
	}


	//nurse home
	public function nurse(){
		if (Auth::check()) {
			# code...
			return view('dash.nurse');
		}

		return redirect('auth/logout');
	}

	//patient home
	public function patient(){
		if (Auth::check()) {
			# code...
			//$specialists=$this->getSpecialists();
			$specialismList=$this->getSpecialismList();
			Session::put('specialismList',$specialismList);
			//dd(Session::get('specialismList'));  
			return view('dash.patient');
		}

		return redirect('auth/logout');
	}

	//index page
	public function index(){
		if (Auth::check()) {
			# code...
			Auth::logout(); 
		}
		return view('home.index'); 
	}


	public function getSpecialismList(){
		return Specialism::lists('specialism'); 
	}

/*	public function test(){
		dd(env('MANDRILL_SECRET'));
	}
	*/

	/**
	 * list all specialists 
	 */
/*	public function getSpecialists(){
		$specialists = DB::table('specialisms')
						->join('profiles','profiles.user_id','=','specialisms.user_id')
						->select('specialisms.user_id as user_id','specialisms.id as specialism_id','profiles.first_name','profiles.last_name','specialisms.qualification','specialisms.specialism')
						->get(); 
		return $specialists; 
	} */

}
