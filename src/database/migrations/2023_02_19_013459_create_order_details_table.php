<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('orderDetails', function (Blueprint $table) {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->integer('order_total_number');
            $table->integer('price');
            $table->string('url');
            $table->string('owner');
            $table->string('order_id');
            $table->foreign('order_id')->references('uuid')->on('orders')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('photo_id', 255);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}
