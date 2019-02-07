<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminToUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('users', function (Blueprint $table) {

		});
		// Insert some stuff
		DB::table('users')->insert(
			array(
				'username' => 'martin.krivda',
				'firstname' => 'Martin',
				'lastname' => 'Křivda',
				'password' => '$2y$10$QP9nwVvNGqZNwJDR2XlfneTnm2VSfwd55h0r7mwVS9AqLBymMkKFu',
				'hash' => 'bc6dc48b743dc5d013b1abaebd2faed2',
				'email' => 'MKrivda@outlook.com',
				'remember_token' => 'e369853df766fa44e1ed0ff613f563bd',
				'active' => 1,
				'lastlogin' => date("Y-m-d H:i:s"),
				'created_at' => date("Y-m-d H:i:s"),
				'updated_at' => date("Y-m-d H:i:s"),
			)
		);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('users', function (Blueprint $table) {
			//
		});
		DB::table('users')->where("username", 'martin.krivda')->delete();
	}
}
