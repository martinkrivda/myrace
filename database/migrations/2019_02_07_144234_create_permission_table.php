<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('permission', function (Blueprint $table) {
			$table->increments('permission_ID');
			$table->string('name', 50);
			$table->string('for', 30);
			$table->timestamps();
		});

		Schema::create('permission_role', function (Blueprint $table) {
			$table->integer('role_ID')->unsigned();
			$table->integer('permission_ID')->unsigned();
			$table->foreign('role_ID')->references('role_ID')->on('role')->onDelete('restrict');
			$table->foreign('permission_ID')->references('permission_ID')->on('permission')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('permission_role');
		Schema::dropIfExists('permission');
	}
}
