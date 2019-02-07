<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
	public $fillable = ['name', 'for'];
	protected $table = 'permission';
	protected $primaryKey = 'permission_ID';
}
