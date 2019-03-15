<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('payment', function (Blueprint $table) {
			$table->increments('payment_ID');
			$table->integer('transactionId')->unsigned()->comment('Transaction ID');
			$table->date('date')->comment('Date of transaction');
			$table->decimal('amount', 18, 2)->default(0.00)->comment('Volume of received money');
			$table->char('currency', 3)->comment('Currency');
			$table->string('accountId', 255)->nullable()->comment('Bank account number');
			$table->string('bankCode', 10)->nullable()->comment('Bank code');
			$table->string('bankName', 255)->nullable()->comment('Bank name');
			$table->char('ks', 4)->nullable()->comment('Constant symbol');
			$table->char('vs', 10)->nullable()->comment('Variable symbol');
			$table->char('ss', 10)->nullable()->comment('Specific symbol');
			$table->string('message', 140)->nullable()->comment('Meesage for receiver');
			$table->string('autor', 50)->nullable()->comment('Autor');
			$table->string('bic', 11)->nullable()->comment('BIC');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('payment');
	}
}
