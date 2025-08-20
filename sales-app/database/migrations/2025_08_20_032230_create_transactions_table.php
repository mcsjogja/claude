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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->enum('jenis_transaksi', ['penjualan', 'pembelian']);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 15, 2);
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal_transaksi')->useCurrent();
            $table->timestamps();
            
            // Indexes
            $table->index('jenis_transaksi');
            $table->index('tanggal_transaksi');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
