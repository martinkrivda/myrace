<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaceEdition extends Model {
	public $fillable = ['race_ID', 'editionname', 'edition_nr', 'date', 'firststart', 'eventoffice', 'location', 'gps', 'web', 'entrydate1', 'competition', 'eventdirector', 'mainreferee', 'entriesmanager', 'jury1', 'jury2', 'jury3', 'rank_koef', 'cancelled', 'cancelreason', 'protocol'];
	protected $table = 'raceedition';
	protected $primaryKey = 'edition_ID';

	/**
	 * The competitions that belong to the race.
	 */
	public function competitions() {
		return $this->belongsToMany('App\ProposalLists', 'race_competition', 'edition_ID', 'list_ID');
	}
}
