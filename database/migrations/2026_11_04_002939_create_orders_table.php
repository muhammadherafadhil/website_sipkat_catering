<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 30)->unique();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->string('recipient_name', 150);
            $table->string('recipient_phone', 20);
            $table->text('delivery_address');
            $table->dateTime('requested_delivery_at');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('delivery_fee', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->string('order_status', 30)->default('Menunggu Konfirmasi');
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'order_status']);
            $table->index('requested_delivery_at');
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};