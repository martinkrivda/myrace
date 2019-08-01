<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRankingToRunnerTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('runner', function (Blueprint $table) {
			$table->integer('csos_rank')->nullable()->after('csos_lic')->comment('ČSOS Ranking koeficient');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('runner', function (Blueprint $table) {
			$table->dropColumn('csos_rank');
		});
	}
}
