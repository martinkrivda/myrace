<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('notification', function (Blueprint $table) {
			$table->increments('notification_ID');
			$table->integer('registration_ID')->unsigned();
			$table->enum('type', ['finish', 'registration', 'starttime']);
			$table->char('kind', 1);
			$table->string('text', 255);
			$table->string('email', 255)->nullable();
			$table->char('phone', 13)->nullable();
			$table->timestamps();
			$table->foreign('registration_ID')->references('registration_ID')->on('registration')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('notification');
	}
}
