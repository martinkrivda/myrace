<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
	public $fillable = ['EPC', 'active'];
	protected $table = 'tag';
	protected $primaryKey = 'tag_ID';
}
