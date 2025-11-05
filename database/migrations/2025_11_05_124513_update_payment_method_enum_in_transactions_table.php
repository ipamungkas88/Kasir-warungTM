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
        // Untuk MySQL, kita perlu drop dan recreate kolom enum
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });
        
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'qris', 'digital'])->default('cash')->after('total_items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });
        
        Schema::table('transactions', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'card', 'digital'])->default('cash')->after('total_items');
        });
    }
};
