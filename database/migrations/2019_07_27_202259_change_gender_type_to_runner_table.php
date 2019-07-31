<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeGenderTypeToRunnerTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('runner', function (Blueprint $table) {
			$this->changeColumnType("runner", "gender", "ENUM('male', 'female') NOT NULL");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('runner', function (Blueprint $table) {
			$table->char('gender', 6)->change();
		});
	}

	public function changeColumnType($table, $column, $newColumnType) {
		DB::statement("ALTER TABLE $table CHANGE $column $column $newColumnType");
	}
}
