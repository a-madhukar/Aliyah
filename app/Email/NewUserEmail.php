<?php namespace App\Email; 

interface NewUserEmail{

	/**
	 * send email 
	 */
	public function sendEmail($email,$password,$view);
}