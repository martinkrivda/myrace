<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimemsToRegistrationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('registration', function (Blueprint $table) {
			$table->integer('timems')->unsigned()->nullable()->after('payref')->comment('Total time in miliseconds');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('registration', function (Blueprint $table) {
			$table->dropColumn('timems');
		});
	}
}
