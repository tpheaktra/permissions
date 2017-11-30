<?php namespace App\Model;

use Zizaco\Entrust\EntrustRole;
//use Illuminate\Database\Eloquent\Model;
class Role extends EntrustRole
{
	protected $table = 'tbl36b12_roles';
	protected $fillable = [
		'name',
		'display_name'
	];
}