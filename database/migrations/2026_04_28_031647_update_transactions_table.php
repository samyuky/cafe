<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Hapus kolom table_number
            $table->dropColumn('table_number');
            
            // Tambah kolom baru
            $table->string('customer_name')->after('user_id');
            $table->string('queue_number')->after('customer_name')->nullable();
            $table->enum('payment_method', ['tunai', 'qris', 'debit', 'kredit', 'gopay', 'ovo'])->default('tunai')->after('payment_amount');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('total_amount');
            $table->decimal('subtotal', 10, 2)->default(0)->after('total_amount');
            
            // Update total_amount position
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('table_number')->after('user_id');
            $table->dropColumn(['customer_name', 'queue_number', 'payment_method', 'tax_amount', 'subtotal']);
        });
    }
};