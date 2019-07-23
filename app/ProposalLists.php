<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalLists extends Model {
	public $fillable = ['module', 'listname', 'field1', 'field2'];
	protected $table = 'proposal_lists';
	protected $primaryKey = 'list_ID';
}
