<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReaderTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('reader', function (Blueprint $table) {
			$table->increments('read_ID');
			$table->integer('edition_ID')->unsigned();
			$table->char('gateway', 6);
			$table->ipAddress('rfid_reader')->nullable();
			$table->bigInteger('EPC')->unsigned();
			$table->year('year');
			$table->dateTime('time', 2);
			$table->timestamps();
			$table->foreign('edition_ID')->references('edition_ID')->on('raceedition')->onDelete('restrict');
			$table->index('EPC');
		});
		DB::statement("ALTER TABLE reader comment 'Table records dats from RFID reader.'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('reader');
	}
}
