<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCsosLicenseRegistrationSiidToRunnerTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('runner', function (Blueprint $table) {
			$table->char('csos_reg', 10)->nullable()->after('club')->comment('ČSOS registration (CHC9501)');
			$table->char('csos_lic', 1)->nullable()->after('csos_reg')->comment('ČSOS license');
			$table->integer('siid')->unsigned()->nullable()->after('csos_lic')->comment('SportIdent ID');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('runner', function (Blueprint $table) {
			$table->dropColumn('siid');
			$table->dropColumn('csos_lic');
			$table->dropColumn('csos_reg');
		});
	}
}
