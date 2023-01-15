<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_return_items', function (Blueprint $table) {
            $table->id();
            // $table->integer('sub_category_id')->default(0);
            $table->integer('style_no_id')->default(0);
            $table->integer('purchase_return_id')->default(0);
            $table->string('color')->nullable();
            $table->integer('qty')->default(0);
            $table->string('barcode')->nullable();
            // $table->string('size')->nullable();
            // $table->string('price')->default(0);
            // $table->string('taxable')->default(0);
            // $table->string('discount')->default(0);
            // $table->string('total_igst')->default(0);
            // $table->string('total_sgst')->default(0);
            // $table->string('total_cgst')->default(0);
            // $table->string('total_amount')->default(0);
            $table->date('date')->nullable();
            $table->string('time')->nullable();
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
        Schema::dropIfExists('purchase_return_items');
    }
}
