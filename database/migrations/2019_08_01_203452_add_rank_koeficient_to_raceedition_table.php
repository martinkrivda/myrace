<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRankKoeficientToRaceeditionTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('raceedition', function (Blueprint $table) {
			$table->integer('rank_koef')->unsigned()->nullable()->after('jury3')->comment('ČSOS Ranking koeficient');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('raceedition', function (Blueprint $table) {
			$table->dropColumn('rank_koef');
		});
	}
}
