<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model {
	public $fillable = ['regsummary_ID', 'edition_ID', 'runner_ID', 'club_ID', 'category_ID', 'stime_ID', 'tag', 'bib_nr', 'firstname', 'lastname', 'yearofbirth', 'gender', 'club', 'entryfee', 'payref', 'checktimems', 'starttimems', 'finishtimems', 'timems', 'status', 'paid', 'DNS', 'DNF', 'DSQ', 'note', 'source', 'importid', 'version', 'creator_ID'];
	protected $table = 'registration';
	protected $primaryKey = 'registration_ID';
}
