<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable {
	use HasApiTokens, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'firstname', 'lastname', 'email', 'password', 'username', 'hash', 'avatar', 'name', 'active', 'google_ID', 'facebook_ID', 'lastlogin',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	protected $table = 'users';
	protected $primaryKey = 'id';

	/**
	 * The role that belong to the user.
	 */
	public function roles() {
		return $this->belongsToMany('App\Role', 'user_role', 'user_ID', 'role_ID');
	}
}
