<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Runner extends Model
{
	 public $fillable = ['firstname','lastname', 'vintage', 'gender', 'country', 'email', 'phone'];
    protected $table = 'runner';
	protected $primaryKey = 'runner_ID';
}