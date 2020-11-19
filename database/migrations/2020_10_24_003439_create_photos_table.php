<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->String('path');
            $table->integer('actor_id')->nullable()->onDelete('NO ACTION')->onUpdate('NO ACTION');
            $table->integer('movie_id')->nullable()->onDelete('NO ACTION')->onUpdate('NO ACTION');
            $table->integer('series_id')->nullable()->onDelete('NO ACTION')->onUpdate('NO ACTION');
            $table->integer('season_id')->nullable()->onDelete('NO ACTION')->onUpdate('NO ACTION');
            $table->integer('blog_id')->nullable()->onDelete('NO ACTION')->onUpdate('NO ACTION');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
