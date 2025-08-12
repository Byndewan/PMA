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
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_number')->unique()->nullable();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->enum('status', ['queue', 'process', 'done', 'taken'])->default('queue');
                $table->text('customer_name')->nullable();
                $table->text('phone')->nullable();
                $table->decimal('total_price', 12, 2);
                $table->decimal('operator_fee_total', 12, 2)->default(0);
                $table->text('notes')->nullable();
                $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending')->nullable();
                $table->text('shipping_address')->nullable()->nullable();
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
