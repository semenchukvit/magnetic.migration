<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCollectionProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_product', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('collection_id', 15,1);
            $table->foreign('collection_id')->references('id')->on('collections');
            $table->decimal('product_id', 15,1);
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collection_product');
    }
}
