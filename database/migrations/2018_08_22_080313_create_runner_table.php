<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunnerTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('runner', function (Blueprint $table) {
			$table->increments('runner_ID');
			$table->string('firstname', 50);
			$table->string('lastname', 255);
			$table->char('yearofbirth', 4);
			$table->char('gender', 6);
			$table->string('email', 255)->nullable();
			$table->char('phone', 13)->nullable();
			$table->char('country', 2);
			$table->char('deleted', 1)->default(0);
			$table->timestamps();
			$table->foreign('country')->references('country_code')->on('country')->onDelete('restrict');
			$table->index(['firstname', 'lastname']);
		});
		DB::statement("ALTER TABLE runner comment 'Table records registered runners.'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('runner');
	}
}
