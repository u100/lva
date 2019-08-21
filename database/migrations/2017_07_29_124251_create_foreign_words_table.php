<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foreign_words', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('vocabulary_list_id')->unsigned();
            $table->string('word');
            $table->string('pattern');
            $table->boolean('native_to_foreign_status');
            $table->integer('word_repeating_counter');
            $table->boolean('success');
            $table->timestamps();

            $table->foreign('vocabulary_list_id')->unsigned()->references('id')->on('vocabulary_lists')->onUpdate('cascade')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('foreign_words');
    }
}

