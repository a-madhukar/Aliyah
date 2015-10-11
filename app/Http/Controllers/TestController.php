<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Email\NewUserEmail; 
use Mail; 
use Illuminate\Http\Request;

class TestController extends Controller {

	//
/*	private $email; 

	public function __construct(NewUserEmail $newUserEmail){
		$this->email = $newUserEmail; 
	}
*/

	public function sendTestEmail(NewUserEmail $newUserEmail){
		$newUserEmail->sendEmail("a.madhukar@yahoo.com","thisWorks123","emails.newUserAccount"); 

		return "done"; 
	}
	

/*	public function sendTestEmail(){
		Mail::send("emails.newUserAccount",['password'=>'1234'],function($message){
			$message->to('a.madhukar@yahoo.com','')->subject('Hello World'); 
		}); 
		return "done";
	}
*/

}
