<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('firstname', 50);
			$table->string('lastname', 255);
			$table->string('name')->nullable();
			$table->string('email', 255)->unique();
			$table->string('password', 255);
			$table->string('remember_token', 100)->nullable();
			$table->string('hash', 32);
			$table->binary('avatar')->nullable();
			$table->char('google_ID', 21)->nullable()->unique();
			$table->boolean('active')->default(0);
			$table->dateTime('lastlogin');
			$table->timestamps();
		});
		DB::statement("ALTER TABLE users comment 'Table records users of the application.'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('users');
	}
}
