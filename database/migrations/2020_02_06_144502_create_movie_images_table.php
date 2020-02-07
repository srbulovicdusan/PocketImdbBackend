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
            $table->integer('image_id')->unsigned();
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
        Schema::dropIfExists('movie_images');
        Schema::table('movies', function (Blueprint $table) {
            $table->integer('image_url')->unsigned()->default(0);
            $table->dropForeign('image_url');
            $table->dropColumn('image_url');


        });
    }
}
