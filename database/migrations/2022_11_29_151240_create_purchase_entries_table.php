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
            $table->integer('purchase_id')->default(0);
            $table->integer('category_id')->default(0);
            $table->integer('sub_category_id')->default(0);
            $table->integer('brand_id')->default(0);
            $table->integer('style_no_id')->default(0);
            $table->string('color')->nullable();
            $table->longText('img')->nullable();
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
