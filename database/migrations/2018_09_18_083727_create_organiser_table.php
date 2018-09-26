<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganiserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organiser', function (Blueprint $table) {
            $table->increments('organiser_ID');
            $table->char('organiser_abbr', 10)->unique();
            $table->string('orgname', 70);
            $table->string('orgname2', 50)->nullable();
            $table->char('taxid', 8)->nullable();
            $table->char('vatid', 10)->nullable();
            $table->string('street', 30)->nullable();
            $table->string('city', 30)->nullable();
            $table->char('postalcode', 5)->nullable();
            $table->char('country', 2);
            $table->string('web', 50)->nullable();
            $table->string('bankaccount', 50)->nullable();
            $table->char('bankcode', 4)->nullable();
            $table->timestamps();
            $table->foreign('country')->references('country_code')->on('country')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organiser');
    }
}
