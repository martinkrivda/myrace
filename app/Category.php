<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	public $fillable = ['edition_ID', 'course_ID', 'categoryname', 'gender', 'entryfee', 'currency', 'starttime', 'sinterval', 'timelimit', 'capacity', 'checkage', 'birthfrom', 'birthto', 'lock', 'source', 'importid'];
	protected $table = 'category';
	protected $primaryKey = 'category_ID';
}
