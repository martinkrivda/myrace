<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RfidReader extends Model {
	public $fillable = ['edition_ID', 'gateway', 'rfid_adress', 'EPC', 'year', 'time'];
	protected $table = 'reader';
	protected $primaryKey = 'read_ID';
}
