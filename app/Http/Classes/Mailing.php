<?php namespace App\Http\Classes; 

use Mail; 
use Auth; 

class Mailing{

	/**
	 * send confirmation mail
	 */
	public function sendMail($email,$password){
		Log::info("sending the email along with the password");
		Log::info("add this functionality in later!");  
	}	


}