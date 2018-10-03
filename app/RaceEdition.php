<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RaceEdition extends Model
{
    public $fillable = ['race_ID', 'editionname', 'edition_nr', 'date', 'firststart', 'eventoffice', 'location', 'gps', 'web', 'entrydate1', 'competition', 'eventdirector', 'mainreferee', 'entriesmanager', 'jury1', 'jury2', 'jury3', 'cancelled', 'cancelreason', 'protocol'];
    protected $table = 'raceedition';
    protected $primaryKey = 'edition_ID';
}
