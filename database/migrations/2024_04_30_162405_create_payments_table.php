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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('monthly_payment', 10, 2);
            $table->date('payment_date')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->foreignId('daily_price_id')
            ->constrained('daily_prices')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('family_account_id')
            ->constrained('family_accounts')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
