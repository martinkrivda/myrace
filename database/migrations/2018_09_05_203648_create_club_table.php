<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club', function (Blueprint $table) {
            $table->increments('club_ID');
            $table->char('abbr', 10)->unique();
            $table->string('name', 70);
            $table->string('name2', 50)->nullable();
            $table->char('taxid', 8)->nullable();
            $table->char('vatid', 10)->nullable();
            $table->string('street', 30);
            $table->string('city', 30);
            $table->char('postalcode', 5);
            $table->char('country', 2);
            $table->string('web', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->char('phone', 13)->nullable();
            $table->boolean('deleted')->default(false);
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
        Schema::dropIfExists('club');
    }
}
