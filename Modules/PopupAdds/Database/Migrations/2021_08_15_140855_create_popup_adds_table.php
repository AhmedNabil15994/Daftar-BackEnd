<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePopupAddsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('popup_adds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image');
            $table->boolean('status')->default(false);
            $table->string('link')->nullable();
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->bigInteger('popupable_id')->nullable();
            $table->string('popupable_type')->nullable();
            $table->integer('sort')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('popup_adds');
    }
}
