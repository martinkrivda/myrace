<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveClubFromRunnerTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('runner', function (Blueprint $table) {
			if (Schema::hasColumn('runner', 'club')) {
				$table->dropColumn('club');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('runner', function (Blueprint $table) {
			if (!Schema::hasColumn('runner', 'club')) {
				$table->string('club', 70)->nullable()->after('club_ID');
			}
		});
	}
}
