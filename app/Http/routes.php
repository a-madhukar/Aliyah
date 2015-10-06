<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]); */

Route::get('/','HomeController@index'); 

//handles the authentication
Route::group(['prefix'=>'auth/'],function(){
	Route::get('login','AuthController@getLoginForm');
	Route::post('login','AuthController@login');
	Route::get('signup','AuthController@getSignUpForm');
	Route::post('signup','AuthController@signUp');  
	Route::get('profile','AuthController@getProfileForm');
	Route::post('profile','AuthController@setupProfile');
	Route::get('logout','AuthController@logout');  
}); 

//takes to the home panel
Route::group(['prefix'=>'home/'],function(){
	Route::get('admin','HomeController@admin');
	Route::get('doctor','HomeController@doctor');
	Route::get('nurse','HomeController@nurse');
	Route::get('patient','HomeController@patient'); 
}); 

Route::group(['prefix'=>'admin'],function(){
	//create routes for doctor
	Route::resource('doctor','DoctorController'); 
	Route::get('doctor/delete/{id}','DoctorController@destroy'); 
	Route::resource('nurse','NurseController'); 
	Route::get('nurse/delete/{id}','NurseController@destroy'); 
	//Route::resource('nurse','NurseController'); 

	Route::get('search/patient','PatientController@searchPatient'); 
	Route::get('patient/history/{id}','PatientController@getBookingHistory'); 
}); 

Route::group(['prefix'=>'doctor'],function(){
	Route::resource('appointment','AppointmentController'); 
}); 

Route::group(['prefix'=>'appointment'],function(){ 
	Route::get('get/{id}','AppointmentController@getApptForSpecialist');   
	Route::post('make','AppointmentController@makeBooking'); 
});

Route::get('search/specialist','SearchController@getSearchForm'); 

