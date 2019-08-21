<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignWordNativeWordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foreign_word_native_word', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('foreign_word_id')->unsigned();
            $table->foreign('foreign_word_id')->unsigned()->references('id')->on('foreign_words')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('native_word_id')->unsigned();
            $table->foreign('native_word_id')->unsigned()->references('id')->on('native_words')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('foreign_word_native_word');
    }
}
