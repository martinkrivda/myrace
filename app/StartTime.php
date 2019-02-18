<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StartTime extends Model {
	public $fillable = ['start_nr', 'tag_ID', 'stime'];
	protected $table = 'starttime';
	protected $primaryKey = 'stime_ID';
}
