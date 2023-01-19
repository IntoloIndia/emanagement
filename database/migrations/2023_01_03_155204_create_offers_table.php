<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_on')->default(0);
            $table->integer('offer_type')->default(0);
            $table->integer('category_id')->default(0);
            $table->integer('sub_category_id')->default(0);
            $table->integer('brand_id')->default(0);
            $table->integer('style_no_id')->default(0);
            $table->string('summary')->default(0);
            $table->integer('discount_offer')->default(0);          
            // $table->string('purcentage')->default(0);
            $table->date('offer_from')->nullable();
            $table->date('offer_to')->nullable();
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
        Schema::dropIfExists('offers');
    }
}
