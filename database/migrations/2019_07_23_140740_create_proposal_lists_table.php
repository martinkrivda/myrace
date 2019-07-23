<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalListsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('proposal_lists', function (Blueprint $table) {
			$table->increments('list_ID');
			$table->char('module', 8);
			$table->string('listname', 32)->comment('List name');
			$table->string('field1', 128)->nullable()->comment('First parameter');
			$table->string('field2', 128)->nullable()->comment('Second parameter');
			$table->timestamps();
		});
		DB::statement("ALTER TABLE proposal_lists comment 'Table records list of parameters'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('proposal_lists');
	}
}
