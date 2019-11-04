<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {
	public $fillable = ['module', 'keyword', 'param1', 'param2'];
	public $timestamps = false;
	protected $table = 'settings';
	protected $primaryKey = 'config_ID';
}
