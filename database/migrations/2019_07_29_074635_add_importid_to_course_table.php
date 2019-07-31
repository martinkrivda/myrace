<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImportidToCourseTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('course', function (Blueprint $table) {
			$table->string('source', 15)->nullable()->after('gpx')->comment('Source system');
			$table->integer('importid')->unsigned()->nullable()->after('source')->comment('Import ID');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('course', function (Blueprint $table) {
			$table->dropColumn('importid');
			$table->dropColumn('source');
		});
	}
}
