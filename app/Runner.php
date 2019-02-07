<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Runner extends Model {
	public $fillable = ['firstname', 'lastname', 'yearofbirth', 'gender', 'country', 'email', 'phone', 'club_ID', 'club', 'deleted'];
	protected $table = 'runner';
	protected $primaryKey = 'runner_ID';
}
