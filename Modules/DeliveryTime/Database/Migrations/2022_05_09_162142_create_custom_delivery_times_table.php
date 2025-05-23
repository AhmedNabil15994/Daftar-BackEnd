<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomDeliveryTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_delivery_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('day_code', 20);
            $table->boolean('status')->default(true);
            $table->boolean('is_full_day')->default(true);
            $table->longText('custom_times')->nullable();
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
        Schema::dropIfExists('custom_delivery_times');
    }
}
