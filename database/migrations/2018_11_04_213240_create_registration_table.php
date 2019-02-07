<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('registration', function (Blueprint $table) {
			$table->increments('registration_ID');
			$table->integer('edition_ID')->unsigned();
			$table->integer('runner_ID')->unsigned();
			$table->integer('club_ID')->unsigned()->nullable();
			$table->integer('category_ID')->unsigned();
			$table->integer('stime_ID')->unsigned()->nullable();
			$table->char('start_nr', 5)->nullable();
			$table->string('firstname', 50);
			$table->string('lastname', 255);
			$table->year('yearofbirth');
			$table->enum('gender', ['male', 'female']);
			$table->string('club', 70)->nullable();
			$table->decimal('entryfee', 8, 2)->default(0.00)->comment('Entry fee');
			$table->char('payref', 10)->comment('Payment reference');
			$table->boolean('paid')->default(false)->comment('Registration is paid');
			$table->boolean('NC')->default(false)->comment('Not compenting');
			$table->boolean('DNS')->default(false)->comment('Did not start');
			$table->boolean('DNF')->default(false)->comment('Did not finish');
			$table->boolean('DSQ')->default(false)->comment('Disqualified');
			$table->text('note')->nullable()->comment('Note');
			$table->integer('creator_ID')->unsigned()->comment('Autor');
			$table->integer('version')->unsigned()->default(1)->comment('Version number');
			$table->timestamps();
			$table->foreign('creator_ID')->references('id')->on('users')->onDelete('restrict');
			$table->foreign('edition_ID')->references('edition_ID')->on('raceedition')->onDelete('restrict');
			$table->foreign('runner_ID')->references('runner_ID')->on('runner')->onDelete('restrict');
			$table->foreign('club_ID')->references('club_ID')->on('club')->onDelete('restrict');
			$table->foreign('category_ID')->references('category_ID')->on('category')->onDelete('restrict');
			$table->foreign('stime_ID')->references('stime_ID')->on('starttime')->onDelete('restrict');
			$table->index(['firstname', 'lastname']);
		});
		DB::statement("ALTER TABLE registration comment 'Table records registration .'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('registration');
	}
}
