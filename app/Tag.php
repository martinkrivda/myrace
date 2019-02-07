<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
	public $fillable = ['EPC'];
	protected $table = 'tag';
	protected $primaryKey = 'tag_ID';
}
