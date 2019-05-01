<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public $fillable = ['name', 'code', 'symbol'];
    public $timestamps = false;
    public $autoincrement = false;
    protected $table = 'currency';
    protected $primaryKey = 'code';
}
