<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeGenderTypeToCategoryTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('category', function (Blueprint $table) {
			$this->changeColumnType("category", "gender", "ENUM('male', 'female') NOT NULL");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('category', function (Blueprint $table) {
			$table->char('gender', 6)->change();
		});
	}

	public function changeColumnType($table, $column, $newColumnType) {
		DB::statement("ALTER TABLE $table CHANGE $column $column $newColumnType");
	}
}
