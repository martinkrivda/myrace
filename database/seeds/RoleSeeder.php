<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$administrator = Role::create([
			'name' => 'Administrator',
		]);
		$editor = Role::create([
			'name' => 'Editor',
		]);
		$speaker = Role::create([
			'name' => 'Speaker',
		]);
	}
}
