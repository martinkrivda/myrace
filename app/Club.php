<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    public $fillable = ['abbr', 'name', 'name2', 'taxid', 'vatid', 'street', 'city', 'postalcode', 'web', 'email', 'deleted'];
    protected $table = 'club';
    protected $primaryKey = 'club_ID';
}
