<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('user_role', function (Blueprint $table) {
			$table->increments('userrole_ID');
			$table->integer('user_ID')->unsigned();
			$table->integer('role_ID')->unsigned();
			$table->timestamps();
			$table->foreign('user_ID')->references('id')->on('users')->onDelete('restrict');
			$table->foreign('role_ID')->references('role_ID')->on('role')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('user_role');
	}
}
