<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_entries', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id')->default(0);
            $table->string('product_code')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->string('product')->nullable();
            $table->integer('qty')->nullable();
            $table->string('purchase_price')->nullable();
            $table->string('sales_price')->nullable();
            $table->integer('size_id')->default(0);
            $table->integer('color_id')->default(0);
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->integer('sell')->default(0);
            $table->integer('sell_by')->default(0);
            $table->integer('status')->default(0);
            $table->text('barcode')->nullable();
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
        Schema::dropIfExists('purchase_entries');
    }
}
