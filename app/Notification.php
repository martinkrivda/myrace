<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
	public $fillable = ['registration_ID', 'type', 'kind', 'text', 'email', 'phone'];
	protected $table = 'notification';
	protected $primaryKey = 'notification_ID';
	protected $type = [
		'finish',
		'registration',
		'starttime',
	];

}
