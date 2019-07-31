<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {
	public $fillable = ['edition_ID', 'coursename', 'surface', 'length', 'climb', 'description', 'gpx', 'source', 'importid'];
	protected $table = 'course';
	protected $primaryKey = 'course_ID';
}
