<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStarttimeTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('starttime', function (Blueprint $table) {
			$table->increments('stime_ID');
			$table->char('start_nr', 5);
			$table->integer('tag_ID')->unsigned();
			$table->dateTime('stime');
			$table->timestamps();
			$table->foreign('tag_ID')->references('tag_ID')->on('tag')->onDelete('restrict');
			$table->index('start_nr');
		});
		DB::statement("ALTER TABLE starttime comment 'Table records start times for the race.'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('starttime');
	}
}
