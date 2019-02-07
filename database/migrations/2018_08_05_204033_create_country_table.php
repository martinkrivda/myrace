<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('country', function (Blueprint $table) {
			$table->integer('country_ID')->unsigned();
			$table->char('country_code', 2);
			$table->string('name', 50);
			$table->timestamps();
			$table->primary('country_code');
			$table->unique('country_ID');
		});
		DB::statement("ALTER TABLE country comment 'Table records countries of the world.'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('country');
	}
}
