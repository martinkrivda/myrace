<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEditionToStarttimeTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('starttime', function (Blueprint $table) {
			$table->integer('edition_ID')->unsigned()->after('stime_ID');
			$table->integer('category_ID')->unsigned()->after('edition_ID');
			$table->foreign('edition_ID')->references('edition_ID')->on('raceedition')->onDelete('restrict');
			$table->foreign('category_ID')->references('category_ID')->on('category')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('starttime', function (Blueprint $table) {
			$table->dropForeign('starttime_edition_id_foreign');
			$table->dropColumn('edition_ID');
			$table->dropForeign('starttime_category_id_foreign');
			$table->dropColumn('category_ID');
		});
	}
}
