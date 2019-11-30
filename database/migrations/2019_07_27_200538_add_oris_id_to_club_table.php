<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrisIdToClubTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('club', function (Blueprint $table) {
			$table->string('source', 15)->nullable()->after('phone')->comment('Source system');
			$table->char('importid', 10)->nullable()->after('source')->comment('Source ID');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('club', function (Blueprint $table) {
			$table->dropColumn('importid');
			$table->dropColumn('source');
		});
	}
}
