<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'firstname', 'lastname', 'email', 'password', 'username', 'hash', 'avatar', 'name', 'active', 'lastlogin',
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
