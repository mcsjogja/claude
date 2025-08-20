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
            $table->bigIncrements('id');
            $table->string('code', 50)->unique();
            $table->string('name', 150);
            $table->string('category', 100);
            $table->integer('stock')->default(0);
            $table->decimal('purchase_price', 12, 2);
            $table->decimal('selling_price', 12, 2);
            $table->timestamps();
            
            // Indexes
            $table->index('category');
            $table->index('name');
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
