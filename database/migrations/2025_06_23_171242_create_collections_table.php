<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Slim Fit T-Shirt"
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // T-Shirts, Shirts, etc.
            $table->foreignId('brand_id')->constrained()->onDelete('cascade'); // Optional brand name
            $table->string('price'); // Price of product
            $table->integer('stock')->default(0); // Quantity available
            $table->string('size')->nullable(); // S, M, L, XL (can also be a separate table)
            $table->string('color')->nullable(); // e.g., Black, White
            $table->string('material')->nullable(); // Cotton, Denim, etc.
            $table->string('fit')->nullable(); // Regular, Slim, etc.
            $table->string('style')->nullable(); // Casual, Formal, etc.
            $table->string('image')->nullable(); // Main product image
            $table->text('description')->nullable(); // Full product description
            $table->text('highlights')->nullable(); // Key features
            $table->boolean('is_featured')->default(false); // For homepage promotion
            $table->boolean('status')->default(true); // Show/hide product
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
        Schema::dropIfExists('collections');
    }
};
