<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrisIdToRunnerTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('runner', function (Blueprint $table) {
			$table->string('source', 15)->nullable()->after('siid')->comment('Source system');
			$table->integer('importid')->unsigned()->nullable()->after('source')->comment('Source ID');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('runner', function (Blueprint $table) {
			$table->dropColumn('importid');
			$table->dropColumn('source');
		});
	}
}
