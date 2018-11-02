<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaceeditionTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('raceedition', function (Blueprint $table) {
			$table->increments('edition_ID');
			$table->integer('race_ID')->unsigned();
			$table->string('editionname', 70)->unique();
			$table->integer('edition_nr')->unsigned()->default(1)->comment('Number of race edition.');
			$table->date('date');
			$table->time('firststart');
			$table->datetime('eventoffice');
			$table->string('location', 50);
			$table->string('gps', 100);
			$table->string('web', 50)->nullable();
			$table->datetime('entrydate1')->nullable();
			$table->string('competition', 155)->nullable();
			$table->string('eventdirector', 50)->nullable();
			$table->string('mainreferee', 50)->nullable();
			$table->string('entriesmanager', 50)->nullable();
			$table->string('jury1', 50)->nullable();
			$table->string('jury2', 50)->nullable();
			$table->string('jury3', 50)->nullable();
			$table->char('cancelled', 1)->default(0);
			$table->string('cancelreason', 100)->nullable();
			$table->text('protocol')->nullable();
			$table->timestamps();
			$table->foreign('race_ID')->references('race_ID')->on('race')->onDelete('restrict');
		});
		DB::statement("ALTER TABLE raceedition comment 'Table records year edition of the races.'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('raceedition');
	}
}
