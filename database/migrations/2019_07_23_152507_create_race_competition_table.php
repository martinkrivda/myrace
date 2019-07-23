<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaceCompetitionTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('race_competition', function (Blueprint $table) {
			$table->integer('edition_ID')->unsigned();
			$table->integer('list_ID')->unsigned();
			$table->foreign('edition_ID')->references('edition_ID')->on('raceedition')->onDelete('restrict');
			$table->foreign('list_ID')->references('list_ID')->on('proposal_lists')->onDelete('restrict');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('race_competition');
	}
}
