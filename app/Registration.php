<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model {
	public $fillable = ['edition_ID', 'runner_ID', 'club_ID', 'tag_ID', 'category_ID', 'stime_ID', 'start_nr', 'firstname', 'lastname', 'yearofbirth', 'gender', 'club', 'entryfee', 'payref', 'timems', 'paid', 'DNS', 'DNF', 'DSQ', 'version', 'creator_ID'];
	protected $table = 'registration';
	protected $primaryKey = 'registration_ID';
}
