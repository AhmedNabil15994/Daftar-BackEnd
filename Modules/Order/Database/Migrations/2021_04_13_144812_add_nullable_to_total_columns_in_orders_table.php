<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableToTotalColumnsInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total_comission', 9, 3)->nullable()->change();
            $table->decimal('total_profit', 9, 3)->nullable()->change();
            $table->decimal('total_profit_comission', 9, 3)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total_comission', 9, 3)->nullable(false)->change();
            $table->decimal('total_profit', 9, 3)->nullable(false)->change();
            $table->decimal('total_profit_comission', 9, 3)->nullable(false)->change();
        });
    }
}
