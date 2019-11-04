<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSplitTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('split', function (Blueprint $table) {
			$table->increments('split_ID');
			$table->integer('edition_ID')->unsigned()->comment('Identifier of race');
			$table->char('gateway', 3)->comment('Identifier of split gate');
			$table->integer('registration_ID')->unsigned()->comment('Registration ID');
			$table->integer('splittimems')->unsigned()->comment('Split time in miliseconds from start');
			$table->timestamps();
			$table->foreign('edition_ID')->references('edition_ID')->on('raceedition')->onDelete('restrict');
			$table->foreign('registration_ID')->references('registration_ID')->on('registration')->onDelete('cascade');
			$table->index('gateway');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('split');
	}
}
