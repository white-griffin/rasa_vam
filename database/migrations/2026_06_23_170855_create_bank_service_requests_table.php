<?php

use App\Enums\BankServiceRequestStatuses;
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
        Schema::create('bank_service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('bank_service_id')->constrained('bank_services');
            $table->string('bank_service_price_title');
            $table->double('bank_service_price_amount');
            $table->json('additional_data')->nullable();
            $table->tinyInteger('status')
                ->default(BankServiceRequestStatuses::PENDING->value);
            $table->text('reject_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_service_requests');
    }
};
