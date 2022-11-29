<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->integer('product_code')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('size_id')->nullable();
            $table->string('price')->nullable();
            $table->float('amount')->nullable();
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
        Schema::dropIfExists('sales_invoices');
    }
}
