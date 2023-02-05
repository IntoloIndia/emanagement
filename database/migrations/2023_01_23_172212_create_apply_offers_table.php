<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplyOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_offers', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_section')->default(0);
            $table->integer('offer_id')->default(0);
            $table->integer('offer_type')->default(0);
            $table->integer('category_id')->default(0);
            $table->integer('sub_category_id')->default(0);
            $table->integer('brand_id')->default(0);
            $table->integer('style_no_id')->default(0);
            $table->date('offer_from')->nullable();
            $table->date('offer_to')->nullable();
            $table->string('offer_start_time')->nullable();
            $table->string('offer_end_time')->nullable();
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
        Schema::dropIfExists('apply_offers');
    }
}
