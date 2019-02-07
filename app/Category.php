<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	public $fillable = ['edition_ID', 'categoryname', 'length', 'climb', 'entryfee', 'starttime', 'sinterval', 'timelimit', 'capacity', 'checkage', 'birthfrom', 'birthto'];
	protected $table = 'category';
	protected $primaryKey = 'category_ID';
}
