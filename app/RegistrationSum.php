<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationSum extends Model {
	public $fillable = ['edition_ID', 'name', 'email', 'price', 'discount', 'totalprice', 'payref', 'status', 'creator_ID'];
	protected $table = 'registrationsum';
	protected $primaryKey = 'regsummary_ID';

	/**
	 * Scope a query to only include users of a given type.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder $query
	 * @param  mixed $edition_ID
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeOfEdition($query, $edition_ID) {
		return $query->where('edition_ID', $edition_ID);
	}
}
