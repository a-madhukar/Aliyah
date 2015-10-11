<?php namespace App\Email\Mandrill; 

use App\Email\NewUserEmail as NewUserEmailInterface;
//use Illuminate\Mail\Mailer; 
use Mail;  

class NewUserEmail implements NewUserEmailInterface{

 //protected $mail; 

	/**
	 * constructor
	 */
/*	public function __construct(Mailer $mail){
		$this->mail = $mail; 
	}
*/
	/**
	 * implement the send Email function
	 */
	public function sendEmail($email,$password,$view){
		Mail::send($view,['email'=>$email,'password'=>$password],function($message) use($email)
		{
			$message->to($email)->subject('A New Account Has Been Created For You'); 
		}); 
	}
}