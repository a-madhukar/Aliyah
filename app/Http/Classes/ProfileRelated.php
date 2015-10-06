<?php namespace App\Http\Classes;

use App\Profile; 

class ProfileRelated {

	//test function
	public static function display(){
		return "Hello World!"; 
	}

	//create the profile 
	public static function createProfileInstance($userId,$input){
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

	//sets the rules for Profile Validation
	public static function getValRulesForProfiles(){
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

}