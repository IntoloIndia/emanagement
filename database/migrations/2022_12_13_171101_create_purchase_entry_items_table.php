<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseEntryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_entry_items', function (Blueprint $table) {
            $table->id();
            $table->integer('purchase_entry_id')->default(0);
            $table->string('size')->nullable();
            $table->integer('qty')->default(0);
            $table->string('price')->nullable();
            $table->string('mrp')->nullable();
            $table->integer('discount')->default(0);
            $table->float('sgst')->default(0);
            $table->float('cgst')->default(0);
            $table->float('igst')->default(0);
            $table->string('barcode')->nullable();
            $table->longtext('barcode_img')->nullable();
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
        Schema::dropIfExists('purchase_entry_items');
    }
}
