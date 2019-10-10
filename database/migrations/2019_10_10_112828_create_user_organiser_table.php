<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserOrganiserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_organiser', function (Blueprint $table) {
            $table->integer('user_ID')->unsigned();
            $table->integer('organiser_ID')->unsigned();
            $table->foreign('user_ID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('organiser_ID')->references('organiser_ID')->on('organiser')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_organiser');
    }
}
