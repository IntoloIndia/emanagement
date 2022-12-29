<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_bills', function (Blueprint $table) {
            $table->id();
            $table->integer('cutomer_id')->default(0);
            $table->integer('bill_date')->default(0);
            $table->integer('bill_time')->default(0);
            $table->integer('total_amount')->default(0);
            $table->integer('pay_online')->default(0);
            $table->integer('pay_cash')->default(0);
            $table->integer('pay_card')->default(0);
            $table->integer('pay_credit')->default(0);
            $table->float('earned_point')->default(0);
            $table->float('redeem_point')->default(0);
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
        Schema::dropIfExists('customer_bills');
    }
}
