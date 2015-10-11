<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//use App\Email\NewUserEmail as NewUserEmailInterface;
//use App\Email\Mandrill\NewUserEmail; 
use App;

class NewUserEmailServiceProvider extends ServiceProvider {

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
		//	App::bind('NewUserEmailInterface','NewUserEmail'); 
		$this->app->bind(
			'App\Email\NewUserEmail',
			'App\Email\Mandrill\NewUserEmail'
		);
	}

}
