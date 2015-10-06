<?php namespace App\Http\Classes;

use App\User; 
use App\Profile;
use Log;

class UserRelated {

	/**
	 * create profile
	 */
	public static function createProfile(
			$user_id,
			$first_name,
			$last_name,
			$address_line1,
			$address_line2,
			$city,
			$state,
			$country,
			$postcode,
			$phone,
			$passport_no
		)
	{
		Log::info("creating the profile.");
		$profile=Profile::create([
				'user_id'=>$user_id,
				'first_name'=>$first_name,
				'last_name'=>$last_name,
				'address_line1'=>$address_line1,
				'address_line2'=>$address_line2, 
				'city'=>$city, 
				'state'=>$state,
				'country'=>$country, 
				'postcode'=>$postcode,
				'phone'=>$phone,
				'passport_no'=>$passport_no
			]);  
		return $profile; 
	}


	/**
	 * create random password
	 */
	public static function generatePassword(){
		 $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		    $pass = array(); //remember to declare $pass as an array
		    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		    for ($i = 0; $i < 8; $i++) {
		        $n = rand(0, $alphaLength);
		        $pass[] = $alphabet[$n];
		    }
		    return implode($pass); //turn the array into a string
	}

}