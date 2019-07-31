<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChecktimeStarttimeTagToRegistrationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('registration', function (Blueprint $table) {
			$table->string('tag', 25)->nullable()->after('stime_ID')->comment('Tag ID (sportident id, epc rfid)');
			$table->integer('checktimems')->nullable()->after('payref')->comment('Check time in ms');
			$table->integer('starttimems')->nullable()->after('checktimems')->comment('Start time in ms');
			$table->integer('finishtimems')->nullable()->after('starttimems')->comment('Finish time in ms');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('registration', function (Blueprint $table) {
			$table->dropColumn('tag');
			$table->dropColumn('checktimems');
			$table->dropColumn('starttimems');
			$table->dropColumn('finishtimems');
		});
	}
}
