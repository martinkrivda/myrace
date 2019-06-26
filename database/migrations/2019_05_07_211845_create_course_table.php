<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('course', function (Blueprint $table) {
            $table->increments('course_ID');
            $table->integer('edition_ID')->unsigned();
            $table->string('coursename', 50);
            $table->enum('surface', ['road', 'path', 'terrain', 'miscellaneous', 'sand'])->comment('Surface of course');
            $table->integer('length')->nullable()->comment('Length in meters');
            $table->integer('climb')->nullable()->comment('Climb in meters');
            $table->text('description')->nullable()->comment('Course description');
            $table->mediumText('gpx')->nullable()->comment('GPX file');
            $table->timestamps();
            $table->foreign('edition_ID')->references('edition_ID')->on('raceedition')->onDelete('cascade');
        });
        DB::statement("ALTER TABLE course comment 'Table records competition courses.'");
        Schema::table('category', function (Blueprint $table) {
            $table->integer('course_ID')->unsigned()->after('edition_ID')->comment('Course ID');
            $table->foreign('course_ID')->references('course_ID')->on('course')->onDelete('restrict');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropForeign('category_course_id_foreign');
            $table->dropColumn('course_ID');
        });
        Schema::dropIfExists('course');
    }
}
