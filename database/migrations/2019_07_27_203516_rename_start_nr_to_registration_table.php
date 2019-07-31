<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameStartNrToRegistrationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('registration', function (Blueprint $table) {
			DB::statement('ALTER TABLE registration CHANGE start_nr bib_nr CHAR(5) NULL');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('registration', function (Blueprint $table) {
			DB::statement('ALTER TABLE registration CHANGE bib_nr start_nr CHAR(5) NULL');
		});
	}
}
