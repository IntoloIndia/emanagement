<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerBillInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_bill_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('bill_id')->nullable();
            $table->integer('product_code')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('qty')->nullable();
            $table->string('size')->nullable();
            $table->string('price')->nullable();
            $table->float('amount')->nullable();
            $table->float('taxfree_amount')->nullable();
            $table->float('sgst')->default(0);
            $table->float('cgst')->default(0);
            $table->float('igst')->nullable(0);
            $table->integer('alteration_voucher')->nullable(0);
            $table->date('date')->nullable();
            $table->string('time')->nullable();
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
        Schema::dropIfExists('customer_bill_invoices');
    }
}
