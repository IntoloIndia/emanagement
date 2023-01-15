<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentReceivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_receivings', function (Blueprint $table) {
            $table->id();
            $table->integer('against_bill_id')->default(0);
            $table->integer('customer_id')->default(0);
            $table->integer('pay_online')->default(0);
            $table->integer('pay_cash')->default(0);
            $table->integer('pay_card')->default(0);
            $table->integer('balance_amount')->default(0);
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
        Schema::dropIfExists('payment_receivings');
    }
}
