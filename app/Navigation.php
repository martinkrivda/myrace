<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    public $fillable = ['edition_ID', 'editionname', 'edition_nr'];
    protected $table = 'raceedition';
    protected $primaryKey = 'edition_ID';
}
