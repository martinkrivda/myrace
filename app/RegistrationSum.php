<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationSum extends Model {
	public $fillable = ['edition_ID', 'name', 'email', 'price', 'discount', 'totalprice', 'payref', 'status', 'creator_ID'];
	protected $table = 'registrationsum';
	protected $primaryKey = 'regsummary_ID';
}
