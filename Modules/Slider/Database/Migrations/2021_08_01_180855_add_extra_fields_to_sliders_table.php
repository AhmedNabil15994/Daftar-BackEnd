<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldsToSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->date('start_at')->nullable()->after('link');
            $table->date('end_at')->nullable()->after('start_at');
            $table->bigInteger('sliderable_id')->nullable()->after('end_at');
            $table->string('sliderable_type')->nullable()->after('sliderable_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['sliderable_id', 'sliderable_type', 'start_at', 'end_at']);
        });
    }
}
