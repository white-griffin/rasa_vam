<?php

use App\Enums\OrderStatuses;
use App\Enums\PaymentGateways;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->tinyInteger('gateway')
                ->default(PaymentGateways::ZARINPAL);
            $table->tinyInteger('payment_status')
                ->default(OrderStatuses::PENDING->value)
                ->comment('1 For Pending , 2 For Paid , 3 For Cancelled, 4 For Failed');
            $table->string('transaction_id')->nullable()->unique();
            $table->string('authority')->nullable()->index();
            $table->string('reference_id')->nullable()->index();
            $table->json('gateway_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->softDeletes();
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
