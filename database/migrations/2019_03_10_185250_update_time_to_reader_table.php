<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTimeToReaderTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table('reader', function (Blueprint $table) {
			$table->dateTime('time', 2)->change();
			$table->string('epc', 25)->change();
		});
		Schema::table('tag', function (Blueprint $table) {
			$table->string('epc', 25)->change();
		});
		DB::statement("ALTER TABLE reader MODIFY COLUMN `time` DATETIME(2);");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table('reader', function (Blueprint $table) {
			$table->dateTime('time')->change();
			$table->bigInteger('EPC')->unsigned()->change();
		});
		Schema::table('tag', function (Blueprint $table) {
			$table->bigInteger('EPC')->unsigned()->change();
		});
	}
}
