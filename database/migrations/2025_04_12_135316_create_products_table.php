<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->integerIncrements('product_id');
            $table->string('product_name');
            $table->string('product_image');
            $table->string('product_description');
            $table->unsignedBigInteger('product_price');
            $table->unsignedBigInteger('listed_price');
            $table->string('product_slug');
            $table->string('product_status')->default('active');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
