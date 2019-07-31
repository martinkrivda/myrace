<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model {
	public $fillable = ['clubabbr', 'clubname', 'clubname2', 'taxid', 'vatid', 'street', 'city', 'postalcode', 'web', 'email', 'phone', 'country', 'source', 'orisid', 'deleted'];
	protected $table = 'club';
	protected $primaryKey = 'club_ID';
	protected $rules = [
		'clubabbr' => 'required|string|min:3|max:10|unique:club',
	];
}
