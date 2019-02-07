<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegsummaryToRegistrationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('registration', function (Blueprint $table) {
			if (Schema::hasColumn('registration', 'regsummary_ID')) {
				//
			} else {
				$table->integer('regsummary_ID')->unsigned()->default(0)->after('registration_ID')->comment('Index to registrations summary');
			}
			$table->foreign('regsummary_ID')->references('regsummary_ID')->on('registrationsum')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('registration', function (Blueprint $table) {
			if (Schema::hasColumn('registration', 'regsummary_ID')) {
				$table->dropForeign(['regsummary_ID']);
				$table->dropColumn('regsummary_ID');
			}
		});
	}
}
