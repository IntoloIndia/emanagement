<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->string('product')->nullable();
            $table->integer('qty')->nullable();
            $table->string('price')->nullable();
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
        Schema::dropIfExists('products');
    }
}
