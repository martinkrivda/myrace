<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RfidReader extends Model {
	public $fillable = ['edition_ID', 'gateway', 'rfid_reader', 'EPC', 'year', 'time'];
	protected $table = 'reader';
	protected $primaryKey = 'read_ID';
	protected $dateFormat = 'Y-m-d H:i:s';
}
