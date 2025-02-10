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
        Schema::create('product_varients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('color_id')->constrained('colors')->onDelete('cascade');
            $table->foreignId('size_id')->constrained('sizes')->onDelete('cascade');
            $table->integer('stock_quantity')->default(0);
            $table->decimal('variant_price', 10, 2)->nullable(); 
            $table->string('sku')->unique()->nullable(); // Combination of product code + color + size
            $table->boolean('status')->default(true);
            
            $table->timestamps();
            
            // Make combination unique
            $table->unique(['product_id', 'color_id', 'size_id'], 'unique_variant_combination');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_varients');
    }
};
