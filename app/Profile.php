<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model {

	//

	protected $fillable = [
		'user_id',
		'first_name',
		'last_name',
		'address_line1',
		'address_line2',
		'city',
		'state',
		'country',
		'postcode',
		'phone',
		'passport_no',
	]; 

	public function users(){
		return $this->belongsTo('App\User','user_id'); 
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
	}

}
