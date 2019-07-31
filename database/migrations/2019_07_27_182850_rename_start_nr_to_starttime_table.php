<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameStartNrToStarttimeTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('starttime', function (Blueprint $table) {
			$table->renameColumn('start_nr', 'bib_nr');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('starttime', function (Blueprint $table) {
			$table->renameColumn('bib_nr', 'start_nr');
		});
	}
}
