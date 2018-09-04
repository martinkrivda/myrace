<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClubToRunnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('runner')) {
            Schema::table('runner', function (Blueprint $table) {
                if (!Schema::hasColumn('runner', 'club')) {
                    $table->integer('club_ID')->nullable()->unsigned()->after('country');
                    $table->string('club', 70)->nullable()->after('club_ID');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('runner', function (Blueprint $table) {
            if (Schema::hasColumn('runner', 'club')) {
                $table->dropColumn(['club_ID', 'club']);
            }
        });
    }
}
