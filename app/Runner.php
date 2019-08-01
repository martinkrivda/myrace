<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Runner extends Model {
	public $fillable = ['firstname', 'lastname', 'yearofbirth', 'gender', 'country', 'email', 'phone', 'club_ID', 'csos_reg', 'csos_lic', 'csos_rank', 'siid', 'source', 'orisid', 'deleted'];
	protected $table = 'runner';
	protected $primaryKey = 'runner_ID';
}
