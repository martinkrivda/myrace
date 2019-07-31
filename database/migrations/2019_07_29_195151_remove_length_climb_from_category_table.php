<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveLengthClimbFromCategoryTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('category', function (Blueprint $table) {
			if (Schema::hasColumn('category', 'length')) {
				$table->dropColumn('length');
				$table->dropColumn('climb');
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('category', function (Blueprint $table) {
			if (!Schema::hasColumn('category', 'length')) {
				$table->integer('length')->nullable()->after('gender')->comment('Length in meters');
				$table->integer('climb')->nullable()->after('length')->comment('Climb in meters');
			}
		});
	}
}
