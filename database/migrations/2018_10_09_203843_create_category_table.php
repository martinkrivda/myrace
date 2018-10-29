<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->increments('category_ID');
            $table->integer('edition_ID')->unsigned();
            $table->string('categoryname', 30);
            $table->char('gender', 6);
            $table->integer('length')->nullable()->comment('Length in meters');
            $table->integer('climb')->nullable()->comment('Climb in meters');
            $table->decimal('entryfee', 8, 2)->default(0.00)->comment('Entry fee');
            $table->char('currency', 3)->default('CZK')->comment('Currency od entry fee');
            $table->datetime('starttime')->nullable();
            $table->integer('sinterval')->unsigned()->default(0);
            $table->integer('timelimit')->unsigned()->nullable()->comment('Time limit in minutes');
            $table->char('checkage', 1)->default(0)->comment('If 1, check runners age');
            $table->char('birthfrom', 4)->nullable()->comment('Year of birth allowed from');
            $table->char('birthto', 4)->nullable()->comment('Year of birth allowed to');
            $table->timestamps();
            $table->foreign('edition_ID')->references('edition_ID')->on('raceedition')->onDelete('cascade');
        });
        DB::statement("ALTER TABLE category comment 'Table records category of the race edition.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
