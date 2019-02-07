<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tag', function (Blueprint $table) {
			$table->increments('tag_ID');
			$table->bigInteger('EPC')->unsigned()->unique();
			$table->timestamps();
			$table->index('EPC');
		});
		DB::statement("ALTER TABLE tag comment 'Table records registered RFID tags.'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('tag');
	}
}
