<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovieImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('thumbnail');
            $table->string('fullSize');
            
            $table->timestamps();
        });
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('image_url');
            $table->integer('image_id')->unsigned()->nullable();
            $table->foreign('image_id')
                  ->references('id')
                  ->on('movie_images');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('image_url');
            $table->dropForeign('image_id');
            $table->dropColumn('image_id');
        });
        Schema::dropIfExists('movie_images');

    }
}
