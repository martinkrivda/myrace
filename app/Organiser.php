<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organiser extends Model
{
    public $fillable = ['organiser_abbr', 'orgname', 'orgname2', 'taxid', 'vatid', 'street', 'city', 'country', 'web', 'bankaccount', 'bankcode'];
    protected $table = 'organiser';
    protected $primaryKey = 'organiser_ID';
}
