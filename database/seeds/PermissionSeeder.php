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
	}
}
