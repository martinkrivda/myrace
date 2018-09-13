<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    public $fillable = ['clubabbr', 'clubname', 'clubname2', 'taxid', 'vatid', 'street', 'city', 'postalcode', 'web', 'email', 'country', 'deleted'];
    protected $table = 'club';
    protected $primaryKey = 'club_ID';
}
