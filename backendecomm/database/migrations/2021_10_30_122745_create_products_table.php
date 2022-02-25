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
            $table->integer('category_id');
            $table->string('name');
            $table->string('slug');
            $table->longText('description');
            $table->tinyInteger('status')->default('0');
            $table->tinyInteger('feature')->default('0')->nullable();
            $table->tinyInteger('popular')->default('0')->nullable();
            $table->string('title')->nullable();
            $table->string('metakeyword')->nullable();
            $table->string('metadescription')->nullable();
            $table->string('image')->nullable();
            $table->string('brand');
            $table->string('qty');
            $table->string('sellingPrice');
            $table->string('originalPrice');
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
