<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency', function (Blueprint $table) {
            $table->string('name', 50)->comment('Currency name');
            $table->char('code', 3)->comment('Currency code');
            $table->char('symbol', 5)->comment('Currency symbol');
            $table->primary('code');
        });
        Schema::table('category', function (Blueprint $table) {
            $table->foreign('currency')->references('code')->on('currency')->onDelete('restrict');
        });
        DB::statement("ALTER TABLE currency comment 'Table records list of currencies.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropForeign('category_currency_foreign');
        });
        Schema::dropIfExists('currency');
    }
}
