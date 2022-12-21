<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlterationVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alteration_vouchers', function (Blueprint $table) {
            $table->id();
            $table->date('alteration_date')->default(0);
            $table->string('alteration_time')->nullable();
            $table->integer('customer_id')->nullable();
            $table->integer('bill_id')->nullable();
            // $table->integer('product_id')->nullable();
            $table->integer('checked_alt_voucher')->nullable();
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
        Schema::dropIfExists('alteration_vouchers');
    }
}
