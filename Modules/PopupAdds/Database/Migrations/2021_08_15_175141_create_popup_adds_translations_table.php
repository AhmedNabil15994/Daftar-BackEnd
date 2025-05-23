<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePopupAddsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popup_adds_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->text('short_description')->nullable();
            $table->string('locale')->index();

            $table->bigInteger('popup_adds_id')->unsigned();
            $table->foreign('popup_adds_id')->references('id')->on('popup_adds')->onDelete('cascade');
            $table->unique(['popup_adds_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('popup_adds_translations');
    }
}
