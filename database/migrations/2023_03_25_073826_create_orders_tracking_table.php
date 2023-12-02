<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_tracking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            // $table->foreign('order_id')->references('id')->on('orders');
            $table->unsignedBigInteger('tracking_id');
            // $table->foreign('tracking_id')->references('id')->on('tracking');
            $table->text('description');
            $table->boolean('status');
            $table->dateTime('date');
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
        Schema::dropIfExists('orders_tracking');
    }
}
