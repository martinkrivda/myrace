<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrisIdToRunnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('runner', function (Blueprint $table) {
            $table->string('source', 15)->nullable()->after('siid')->comment('Source system');
            $table->integer('orisid')->unsigned()->nullable()->after('source')->comment('Oris ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('runner', function (Blueprint $table) {
            $table->dropColumn('orisid');
            $table->dropColumn('source');
        });
    }
}
