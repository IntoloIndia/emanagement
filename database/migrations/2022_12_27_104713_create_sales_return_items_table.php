<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_return_items', function (Blueprint $table) {
            $table->id();
            $table->integer('sales_return_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->integer('barcode')->nullable();
            $table->integer('qty')->nullable();
            $table->string('size')->nullable();
            $table->float('mrp')->nullable();
            $table->float('amount')->nullable();
            $table->date('create_date')->nullable();
            $table->string('create_time')->nullable();
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
        Schema::dropIfExists('sales_return_items');
    }
}
