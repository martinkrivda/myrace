<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('settings');
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('config_ID');
            $table->char('module', 8)->comment('Application');
            $table->string('keyword', 20)->unique()->comment('Name of parameter');
            $table->string('param1', 255)->nullable()->comment('Parameter 1');
            $table->string('param2', 255)->nullable()->comment('Parameter 2');
        });
        DB::statement("ALTER TABLE settings comment 'Configuration table.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
