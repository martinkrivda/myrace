<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTagIDNullStarttimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('starttime', function (Blueprint $table) {
           $table->integer('tag_ID')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('starttime', function (Blueprint $table) {
            $table->integer('tag_ID')->unsigned()->change();
        });
    }
}
