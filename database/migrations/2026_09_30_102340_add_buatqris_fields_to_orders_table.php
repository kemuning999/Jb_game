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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_gateway')->default('buatqris')->after('order_status');
            $table->string('qris_transaction_id')->nullable()->index()->after('payment_gateway');
            $table->text('qris_url')->nullable()->after('qris_transaction_id');
            $table->longText('qris_image')->nullable()->after('qris_url');
            $table->string('payment_url')->nullable()->after('qris_image');
            $table->timestamp('qris_expires_at')->nullable()->after('payment_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_gateway',
                'qris_transaction_id',
                'qris_url',
                'qris_image',
                'payment_url',
                'qris_expires_at',
            ]);
        });
    }
};
