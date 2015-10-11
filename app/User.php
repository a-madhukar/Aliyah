<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['email', 'password','type'];
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


	/**
	 * has one to one relationship with profile
	 */ 
	public function profiles(){
		return $this->hasOne('App\Profile','user_id'); 
	}

	/**
	 * relationship with doctor
	 */
	public function specialisms(){
		return $this->hasOne('App\Specialism','user_id'); 
	}

	/**
	 * relationship with responsibilities
	 */
	public function responsibilities(){
		return $this->hasOne('App\Responsibility','user_id'); 
	}

	/**
	 *  relationships with appointments
	 */
	public function appointments(){
		return $this->hasMany('App\Appointment','user_id'); 
	}

	/**
	 * relationship with booking
	 */
	public function bookings(){
		return $this->hasMany('App\Booking','user_id');
	}

}
