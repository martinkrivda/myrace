<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('history', function (Blueprint $table) {
			$table->increments('history_ID');
			$table->integer('registration_ID')->nullable()->unsigned();
			$table->enum('type', ['registration', 'update', 'deregistration']);
			$table->string('description', 255)->nullable()->comment('Description of event');
			$table->integer('creator_ID')->unsigned()->comment('Autor');
			$table->timestamps();
			$table->foreign('registration_ID')->references('registration_ID')->on('registration')->onDelete('set null');
			$table->foreign('creator_ID')->references('id')->on('users')->onDelete('restrict');
		});
		DB::statement("ALTER TABLE history comment 'Table records registrations history.'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('history');
	}
}
