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
            $table->string('category_id')->nullable();
            $table->string('sub_category_id')->nullable();
            $table->string('product')->nullable();
            $table->integer('qty')->nullable();
            $table->string('price')->nullable();
            $table->string('size_id')->nullable();
            $table->string('color_id')->nullable();
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->number('sell')->default(0);
            $table->number('sell_by')->default(0);
            $table->number('status')->default(0);
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
