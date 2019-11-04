<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOffraceToRegistrationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('registration', function (Blueprint $table) {
			$table->boolean('is_running')->default(false)->after('paid')->comment('Runner did not start yet');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('registration', function (Blueprint $table) {
			$table->dropColumn('is_running');
		});
	}
}
