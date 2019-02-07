<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
	public $fillable = ['name'];
	protected $table = 'role';
	protected $primaryKey = 'role_ID';

	/**
	 * The permission that belong to the role.
	 */
	public function permissions() {
		return $this->belongsToMany('App\Permission', 'permission_role', 'role_ID', 'permission_ID');
	}
}
