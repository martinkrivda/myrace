<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    public $fillable = ['racename', 'race_abbr', 'location', 'organiser_ID', 'web', 'email', 'phone', 'creator_ID', 'deleted'];
    protected $table = 'race';
    protected $primaryKey = 'race_ID';
}
