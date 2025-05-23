<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableToTotalColumnsInOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->decimal('sale_price', 9, 3)->nullable()->change();
            $table->decimal('original_total', 9, 3)->nullable()->change();
            $table->decimal('total_profit', 9, 3)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_products', function (Blueprint $table) {
            $table->decimal('sale_price', 9, 3)->nullable(false)->change();
            $table->decimal('original_total', 9, 3)->nullable(false)->change();
            $table->decimal('total_profit', 9, 3)->nullable(false)->change();
        });
    }
}
