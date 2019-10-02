<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$regcreate = Permission::create([
			'name' => 'Registration-Create',
			'for' => 'registration',
		]);
		$regupdate = Permission::create([
			'name' => 'Registration-Update',
			'for' => 'registration',
		]);
		$regdelete = Permission::create([
			'name' => 'Registration-Delete',
			'for' => 'registration',
		]);
		$regView = Permission::create([
			'name' => 'Registration-View',
			'for' => 'registration',
		]);
		$regView = Permission::create([
			'name' => 'Registration-Audit',
			'for' => 'registration',
		]);
		$startTime = Permission::create([
			'name' => 'StartTime-View',
			'for' => 'starttime',
		]);
		$startTime = Permission::create([
			'name' => 'StartTime-Generate',
			'for' => 'starttime',
		]);
		$resultList = Permission::create([
			'name' => 'ResultList-View',
			'for' => 'results',
		]);
		$clubs = Permission::create([
			'name' => 'Club-View',
			'for' => 'clubs',
		]);
		$clubs = Permission::create([
			'name' => 'Club-Create',
			'for' => 'clubs',
		]);
		$clubs = Permission::create([
			'name' => 'Club-Update',
			'for' => 'clubs',
		]);
		$clubs = Permission::create([
			'name' => 'Club-Delete',
			'for' => 'clubs',
		]);
	}
}
