<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveryStatusIdToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('delivery_status_id')->unsigned()->nullable()->after('order_status_id');
            $table->foreign('delivery_status_id')->references('id')->on('delivery_statuses');
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
            $table->dropForeign('orders_delivery_status_id_foreign');
            $table->dropIndex('orders_delivery_status_id_foreign');
            $table->dropColumn(['delivery_status_id']);
        });
    }
}
