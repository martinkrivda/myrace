<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEditionidToHistoryTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('history', function (Blueprint $table) {
			$table->integer('edition_ID')->unsigned()->after('history_ID');
			$table->foreign('edition_ID')->references('edition_ID')->on('raceedition')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('history', function (Blueprint $table) {
			$table->dropForeign('history_edition_id_foreign');
			$table->dropColumn('edition_ID');
		});
	}
}
