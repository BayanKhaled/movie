<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->String('name')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('categories');
            $table->timestamps();
        });
    }

    /**
    Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->String('name')->unique();
            $table->Integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('categories');//->onDelete('set null');
            $table->timestamps();
        });
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}