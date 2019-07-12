<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsumTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('registrationsum', function (Blueprint $table) {
			$table->increments('regsummary_ID');
			$table->integer('edition_ID')->unsigned();
			$table->string('name');
			$table->string('email', 255)->nullable();
			$table->decimal('price', 8, 2)->default(0.00)->comment('Sum of entry fees');
			$table->decimal('discount', 8, 2)->default(0.00)->comment('Discount to registration');
			$table->decimal('totalprice', 8, 2)->default(0.00)->comment('Total price for registrations');
			$table->char('payref', 10)->comment('Payment reference');
			$table->smallInteger('status')->default(0);
			$table->integer('creator_ID')->unsigned()->comment('Autor');
			$table->timestamps();
			$table->foreign('creator_ID')->references('id')->on('users')->onDelete('restrict');
			$table->foreign('edition_ID')->references('edition_ID')->on('raceedition')->onDelete('restrict');
		});
		DB::statement("ALTER TABLE registrationsum comment 'Table records registrations summary.'");
		/*DB::table('registrationsum')->insert(
				array(
					'regsummary_ID' => '0',
					'edition_ID' => '1',
					'name' => 'Not grouped',
					'email' => 'martin.krivda@kobchocen.cz',
					'payref' => '1902041703',
					'creator_ID' => '1',
					'created_at' => date("Y-m-d H:i:s"),
					'updated_at' => date("Y-m-d H:i:s"),
				)
			);
		*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('registrationsum');
	}
}
