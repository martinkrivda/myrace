<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Split extends Model {
	public $fillable = ['edition_ID', 'gateway', 'registration_ID', 'splittimems'];
	protected $table = 'split';
	protected $primaryKey = 'split_ID';
}
