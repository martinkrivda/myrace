<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model {
	public $fillable = ['history_ID', 'registration_ID', 'type', 'description', 'creator_ID'];
	protected $table = 'history';
	protected $primaryKey = 'history_ID';
}
