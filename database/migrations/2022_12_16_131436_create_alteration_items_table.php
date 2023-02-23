<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlterationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alteration_items', function (Blueprint $table) {
            $table->id();
            $table->integer('alteration_voucher_id')->default(0);
            $table->integer('customer_bill_invoice_id')->default(0);
            $table->integer('item_qty')->default(0);
            $table->integer('delivery_date')->default(0);
            $table->string('remark')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('alteration_items');
    }
}
