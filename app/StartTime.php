<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StartTime extends Model {
	public $fillable = ['edition_ID', 'category_ID', 'bib_nr', 'tag_ID', 'stime'];
	protected $table = 'starttime';
	protected $primaryKey = 'stime_ID';
}
