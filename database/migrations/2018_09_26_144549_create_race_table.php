<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race', function (Blueprint $table) {
            $table->increments('race_ID');
            $table->string('racename', 70)->unique();
            $table->char('race_abbr', 10)->unique();
            $table->string('location', 50);
            $table->integer('organiser_ID')->unsigned();
            $table->string('web', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->char('phone', 13)->nullable();
            $table->integer('creator_ID')->unsigned();
            $table->char('deleted', 1)->default(0);
            $table->timestamps();
            $table->foreign('organiser_ID')->references('organiser_ID')->on('organiser')->onDelete('restrict');
            $table->foreign('creator_ID')->references('id')->on('users')->onDelete('restrict');
        });
        DB::statement("ALTER TABLE race comment 'Table records races.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('race');
    }
}
